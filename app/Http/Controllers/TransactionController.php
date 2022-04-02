<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::latest()
            ->get();
        $response = [
            'message' => 'List of transactions',
            'data' => $transactions,
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validator make
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'type' => 'required|in:expense,revenue',
        ]);

        // validator fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'error' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            // $transaction = Transaction::create($request->all());
            $transaction = Transaction::create([
                'title' => $request->title,
                'amount' => $request->amount,
                'type' => $request->type,
            ]);
            $response = [
                'message' => 'Transaction created',
                'data' => $transaction,
            ];
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Transaction creation failed',
                'error' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::find($id);

        // if transaction is null
        if (is_null($transaction)) {
            return response()->json([
                'message' => 'Transaction not found',
            ], Response::HTTP_NOT_FOUND);
        }

        $response = [
            'message' => 'Transaction found',
            'data' => $transaction,
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validator make
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'type' => 'required|in:expense,revenue',
        ]);

        // validator fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'error' => $validator->errors(),
            ]);
        }

        $transaction = Transaction::find($id);

        // if transaction is null
        if (is_null($transaction)) {
            return response()->json([
                'message' => 'Transaction not found',
            ], Response::HTTP_NOT_FOUND);
        }

        try {
            // $transaction->update($request->all());
            $transaction->update([
                'title' => $request->title,
                'amount' => $request->amount,
                'type' => $request->type,
            ]);
            $response = [
                'message' => 'Transaction updated',
                'data' => $transaction,
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Transaction update failed',
                'error' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::find($id);

        // if transaction is null
        if (is_null($transaction)) {
            return response()->json([
                'message' => 'Transaction not found',
            ], Response::HTTP_NOT_FOUND);
        }

        try {
            $transaction->delete();
            return response()->json([
                'message' => 'Transaction deleted'
            ], Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Transaction deletion failed',
                'error' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
