<?php namespace App\Http\Controllers\API;

use App\Http\Requests;
use Dingo\Api\Routing\Helpers;
use Mitul\Controller\AppBaseController;
use Mitul\Generator\Errors;
use App\Models\News;
use Illuminate\Http\Request;
use App\Libraries\Repositories\NewsRepository;
use Response;
use Schema;

/*
    This class used Dingo/Api and api-generator response wrappers.
    Read the manual about responses, errors and transformers in Dingo:
    https://github.com/dingo/api/wiki
    Read the manual about responses and errors in laravel-api-generator:
    https://github.com/mitulgolakiya/laravel-api-generator/tree/master
*/

class NewsAPIController extends AppBaseController
{
    const MSG_SAVED = 'News saved successfully';
    const MSG_UPDATED = 'News updated successfully';
    const MSG_DELETED = 'News deleted successfully';

    /**
     * \Dingo\Api\Routing
     */
    use Helpers;

    /**
     * Allowed HTTP requests
     * @var string
     */
    protected static $hateoas = [
        'list' => [
            'href' => '/news',
            'methods' => ['GET', 'HEAD', 'POST', 'SEARCH'],
        ],
        'resource' => [
            'href' => '/news/%id',
            'methods' => ['GET', 'HEAD', 'PUT', 'PATCH', 'DELETE'],
        ],
    ];

	/** @var  NewsRepository */
	private $newsRepository;

	function __construct(NewsRepository $newsRepo)
	{
		$this->newsRepository = $newsRepo;
	}

	/**
	 * Display a listing of the News.
	 * GET|HEAD /news
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
	    $input = $request->all();

		$result = $this->newsRepository->search($input);

		$news = $result[0];

		return $this->response()->array($this->structurizeResponse($news->toArray()));
	}

    /**
     * !!! It is just an example! Replace this to normal search!
     * @param $input
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
	public function search($input)
    {
        $query = News::query();

        $columns = Schema::getColumnListing('$TABLE_NAME$');

        foreach($columns as $attribute)
        {
            if(isset($input[$attribute]))
            {
                $query->where($attribute, $input[$attribute]);
            }
        }

        return $query->get();
    }

    /**
	 * Show the form for creating a new News.
	 * GET|HEAD /news/create
	 *
	 * @return Response
	 */
	public function create()
	{
        // maybe, you can return a template for JS
        Errors::throwHttpExceptionWithCode(Errors::CREATION_FORM_NOT_EXISTS, [], static::getHATEOAS());
	}

	/**
	 * Store a newly created News in storage.
     * POST /news
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		if(sizeof(News::$rules) > 0) {
            $this->validateRequestOrFail($request, News::$rules);
        }
        $input = $request->all();

		$news = $this->newsRepository->create($input);
        $response = $this->structurizeResponse($news->toArray(), self::MSG_SAVED
                                                , true, ['%id' => $news->getAttribute('id')]);

        return $this->response()->array($response);
	}

	/**
	 * Display the specified News.
	 * GET|HEAD /news/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id)
	{
        $news = $this->findOrFail($id);
        $response = $this->structurizeResponse($news->toArray(), '', true, ['%id' => $id]);

        return $this->response()->array($response);
	}

	/**
	 * Show the form for editing the specified News.
	 * GET|HEAD /news/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        // maybe, you can return a template for JS
        Errors::throwHttpExceptionWithCode(Errors::EDITION_FORM_NOT_EXISTS, ['id' => $id], static::getHATEOAS(['%id' => $id]));
	}

	/**
	 * Update the specified News in storage.
     * PUT/PATCH /news/{id}
	 *
	 * @param  int    $id
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function update($id, Request $request)
	{
        if(sizeof(News::$rules) > 0) {
            $this->validateRequestOrFail($request, News::$rules);
        }
		$input = $request->all();
		$result = $this->newsRepository->updateRich($input, $id);
		if (!$result) {
            Errors::throwHttpExceptionWithCode(Errors::NOT_FOUND, ['id' => $id], static::getHATEOAS(['%id' => $id]));
        }
        $news = $this->findOrFail($id);
        $response = $this->structurizeResponse($news->toArray(), self::MSG_UPDATED, true, ['%id' => $id]);

        return $this->response()->array($response);
	}

	/**
	 * Remove the specified News from storage.
     * DELETE /news/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->findOrFail($id);
        $this->newsRepository->delete($id);
        $response = $this->structurizeResponse(null, self::MSG_DELETED, true, ['%id' => $id]);

        return $this->response()->array($response);
	}

    /**
     * @param $id
     * @return News|\Illuminate\Support\Collection|null|static
     */
    protected function findOrFail($id)
    {
        $news = $this->newsRepository->find($id);

        if (empty($news)) {
            Errors::throwHttpExceptionWithCode(Errors::NOT_FOUND, ['id' => $id], static::getHATEOAS(['%id' => $id]));
        }

        return $news;
    }

}
