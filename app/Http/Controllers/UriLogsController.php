<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\UriLogCreateRequest;
use App\Http\Requests\UriLogUpdateRequest;
use App\Repositories\UriLogRepository;
use App\Validators\UriLogValidator;

/**
 * Class UriLogsController.
 *
 * @package namespace App\Http\Controllers;
 */
class UriLogsController extends Controller
{
    /**
     * @var UriLogRepository
     */
    protected $repository;

    /**
     * @var UriLogValidator
     */
    protected $validator;

    /**
     * UriLogsController constructor.
     *
     * @param UriLogRepository $repository
     * @param UriLogValidator $validator
     */
    public function __construct(UriLogRepository $repository, UriLogValidator $validator)
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
        $uriLogs = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $uriLogs,
            ]);
        }

        return view('uriLogs.index', compact('uriLogs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UriLogCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(UriLogCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $uriLog = $this->repository->create($request->all());

            $response = [
                'message' => 'UriLog created.',
                'data'    => $uriLog->toArray(),
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
        $uriLog = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $uriLog,
            ]);
        }

        return view('uriLogs.show', compact('uriLog'));
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
        $uriLog = $this->repository->find($id);

        return view('uriLogs.edit', compact('uriLog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UriLogUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(UriLogUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $uriLog = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'UriLog updated.',
                'data'    => $uriLog->toArray(),
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
                'message' => 'UriLog deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'UriLog deleted.');
    }
}
