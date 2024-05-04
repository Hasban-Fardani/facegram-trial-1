<?php

namespace App\Trait;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait ApiTrait
{
    public function validateRequest(Request $request, array $rules)
    {
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            abort(response()->json([
                "message" => "invalid field",
                "errors" => $validator->errors()
            ], 422));
        }

        return $validator->validated();
    }
}