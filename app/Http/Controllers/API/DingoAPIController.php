<?php namespace App\Http\Controllers\API;

use App\Http\Requests;
use Dingo\Api\Routing\Helpers;
use Mitul\Controller\AppBaseController;
use Mitul\Generator\Errors;
use App\Models\Dingo;
use Illuminate\Http\Request;
use App\Libraries\Repositories\DingoRepository;
use Response;
use Schema;

/*
    This class used Dingo/Api and api-generator response wrappers.
    Read the manual about responses, errors and transformers in Dingo:
    https://github.com/dingo/api/wiki
    Read the manual about responses and errors in laravel-api-generator:
    https://github.com/mitulgolakiya/laravel-api-generator/tree/master
*/

class DingoAPIController extends AppBaseController
{
    const MSG_SAVED = 'Dingo saved successfully';
    const MSG_UPDATED = 'Dingo updated successfully';
    const MSG_DELETED = 'Dingo deleted successfully';

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
            'href' => '/dingos',
            'methods' => ['GET', 'HEAD', 'POST', 'SEARCH'],
        ],
        'resource' => [
            'href' => '/dingos/%id',
            'methods' => ['GET', 'HEAD', 'PUT', 'PATCH', 'DELETE'],
        ],
    ];

	/** @var  DingoRepository */
	private $dingoRepository;

	function __construct(DingoRepository $dingoRepo)
	{
		$this->dingoRepository = $dingoRepo;
	}

	/**
	 * Display a listing of the Dingo.
	 * GET|HEAD /dingos
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
	    $input = $request->all();

		$result = $this->dingoRepository->search($input);

		$dingos = $result[0];

		return $this->response()->array($this->structurizeResponse($dingos->toArray()));
	}

    /**
     * !!! It is just an example! Replace this to normal search!
     * @param $input
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
	public function search($input)
    {
        $query = Dingo::query();

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
	 * Show the form for creating a new Dingo.
	 * GET|HEAD /dingos/create
	 *
	 * @return Response
	 */
	public function create()
	{
        // maybe, you can return a template for JS
        Errors::throwHttpExceptionWithCode(Errors::CREATION_FORM_NOT_EXISTS, [], static::getHATEOAS());
	}

	/**
	 * Store a newly created Dingo in storage.
     * POST /dingos
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		if(sizeof(Dingo::$rules) > 0) {
            $this->validateRequestOrFail($request, Dingo::$rules);
        }
        $input = $request->all();

		$dingos = $this->dingoRepository->create($input);
        $response = $this->structurizeResponse($dingos->toArray(), self::MSG_SAVED
                                                , true, ['%id' => $dingos->getAttribute('id')]);

        return $this->response()->array($response);
	}

	/**
	 * Display the specified Dingo.
	 * GET|HEAD /dingos/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id)
	{
        $dingos = $this->findOrFail($id);
        $response = $this->structurizeResponse($dingos->toArray(), '', true, ['%id' => $id]);

        return $this->response()->array($response);
	}

	/**
	 * Show the form for editing the specified Dingo.
	 * GET|HEAD /dingos/{id}/edit
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
	 * Update the specified Dingo in storage.
     * PUT/PATCH /dingos/{id}
	 *
	 * @param  int    $id
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function update($id, Request $request)
	{
        if(sizeof(Dingo::$rules) > 0) {
            $this->validateRequestOrFail($request, Dingo::$rules);
        }
		$input = $request->all();
		$result = $this->dingoRepository->updateRich($input, $id);
		if (!$result) {
            Errors::throwHttpExceptionWithCode(Errors::NOT_FOUND, ['id' => $id], static::getHATEOAS(['%id' => $id]));
        }
        $dingos = $this->findOrFail($id);
        $response = $this->structurizeResponse($dingos->toArray(), self::MSG_UPDATED, true, ['%id' => $id]);

        return $this->response()->array($response);
	}

	/**
	 * Remove the specified Dingo from storage.
     * DELETE /dingos/{id}
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->findOrFail($id);
        $this->dingoRepository->delete($id);
        $response = $this->structurizeResponse(null, self::MSG_DELETED, true, ['%id' => $id]);

        return $this->response()->array($response);
	}

    /**
     * @param $id
     * @return $Dingo|\Illuminate\Support\Collection|null|static
     */
    protected function findOrFail($id)
    {
        $dingos = $this->dingoRepository->find($id);

        if (empty($dingos)) {
            Errors::throwHttpExceptionWithCode(Errors::NOT_FOUND, ['id' => $id], static::getHATEOAS(['%id' => $id]));
        }

        return $dingos;
    }

}
