<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function testPost(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Test endpoint working',
            'received_data' => $request->all(),
            'method' => $request->method(),
            'headers' => $request->headers->all()
        ]);
    }
}
