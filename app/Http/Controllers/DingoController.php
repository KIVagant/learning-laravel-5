<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateDingoRequest;
use Illuminate\Http\Request;
use App\Libraries\Repositories\DingoRepository;
use Mitul\Controller\AppBaseController;
use Response;
use Flash;

class DingoController extends AppBaseController
{

	/** @var  DingoRepository */
	private $dingoRepository;

	function __construct(DingoRepository $dingoRepo)
	{
		$this->dingoRepository = $dingoRepo;
	}

	/**
	 * Display a listing of the Dingo.
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

		$attributes = $result[1];

		return view('dingos.index')
		    ->with('dingos', $dingos)
		    ->with('attributes', $attributes);
	}

	/**
	 * Show the form for creating a new Dingo.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('dingos.create');
	}

	/**
	 * Store a newly created Dingo in storage.
	 *
	 * @param CreateDingoRequest $request
	 *
	 * @return Response
	 */
	public function store(CreateDingoRequest $request)
	{
        $input = $request->all();

		$dingo = $this->dingoRepository->create($input);

		Flash::info('Dingo saved successfully.');

		return redirect(route('dingos.index'));
	}

	/**
	 * Display the specified Dingo.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id)
	{
		$dingo = $this->dingoRepository->find($id);

		if(empty($dingo))
		{
			Flash::error('Dingo not found');
			return redirect(route('dingos.index'));
		}

		return view('dingos.show')->with('dingo', $dingo);
	}

	/**
	 * Show the form for editing the specified Dingo.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$dingo = $this->dingoRepository->find($id);

		if(empty($dingo))
		{
			Flash::error('Dingo not found');
			return redirect(route('dingos.index'));
		}

		return view('dingos.edit')->with('dingo', $dingo);
	}

	/**
	 * Update the specified Dingo in storage.
	 *
	 * @param  int    $id
	 * @param CreateDingoRequest $request
	 *
	 * @return Response
	 */
	public function update($id, CreateDingoRequest $request)
	{
		$dingo = $this->dingoRepository->find($id);

		if(empty($dingo))
		{
			Flash::error('Dingo not found');
			return redirect(route('dingos.index'));
		}

		$dingo = $this->dingoRepository->updateRich($request->all(), $id);

		Flash::info('Dingo updated successfully.');

		return redirect(route('dingos.index'));
	}

	/**
	 * Remove the specified Dingo from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		$dingo = $this->dingoRepository->find($id);

		if(empty($dingo))
		{
			Flash::error('Dingo not found');
			return redirect(route('dingos.index'));
		}

		$dingo = $this->dingoRepository->delete($id);
		
        Flash::info('Dingo deleted successfully.');

		return redirect(route('dingos.index'));
	}

}
