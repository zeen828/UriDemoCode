<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\UriSrtCreateRequest;
use App\Http\Requests\UriSrtUpdateRequest;
use App\Repositories\UriSrtRepository;
use App\Validators\UriSrtValidator;

/**
 * Class UriSrtsController.
 *
 * @package namespace App\Http\Controllers;
 */
class UriSrtsController extends Controller
{
    /**
     * @var UriSrtRepository
     */
    protected $repository;

    /**
     * @var UriSrtValidator
     */
    protected $validator;

    /**
     * UriSrtsController constructor.
     *
     * @param UriSrtRepository $repository
     * @param UriSrtValidator $validator
     */
    public function __construct(UriSrtRepository $repository, UriSrtValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $uriSrts = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $uriSrts,
            ]);
        }

        dd($uriSrts);
        return $uriSrts->toJSON();
        // return view('uriSrts.index', compact('uriSrts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UriSrtCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(UriSrtCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $uriSrt = $this->repository->create($request->all());

            $response = [
                'message' => 'UriSrt created.',
                'data'    => $uriSrt->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $uriSrt = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $uriSrt,
            ]);
        }

        return view('uriSrts.show', compact('uriSrt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $uriSrt = $this->repository->find($id);

        return view('uriSrts.edit', compact('uriSrt'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UriSrtUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(UriSrtUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $uriSrt = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'UriSrt updated.',
                'data'    => $uriSrt->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'UriSrt deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'UriSrt deleted.');
    }
}
