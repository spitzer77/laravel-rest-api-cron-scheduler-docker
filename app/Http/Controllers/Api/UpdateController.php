<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Exception;

class UpdateController extends Controller
{
    public function createOrUpdateUsers()
    {
        $url = "https://jsonplaceholder.typicode.com/users";
        $content = file_get_contents($url);

        if (!$content) {
            return response()->json(['error' => true, 'message' => 'No content for parse JSON'], 200);
        }

        if (!Str::isJson($content)) {
            return response()->json(['error' => true, 'message' => 'Invalid JSON'], 200);
        };

        $data = json_decode($content, true);

        $input = [
            '*.name' => 'required|string',
            '*.username' => 'required|string',
            '*.email' => 'required|string',
            '*.address' => 'required|array',
            '*.address.street' => 'required|string',
            '*.address.suite' => 'required|string',
            '*.address.city' => 'required|string',
            '*.address.zipcode' => 'required|string',
            '*.address.geo' => 'required|array',
            '*.address.geo.lat' => 'required|numeric',
            '*.address.geo.lng' => 'required|numeric',
            '*.phone' => 'required|string',
            '*.website' => 'required|string',
            '*.company' => 'required|array',
            '*.company.name' => 'required|string',
            '*.company.catchPhrase' => 'required|string',
            '*.company.bs' => 'required|string',
        ];

        $messages = [
            'required' => 'The :attribute field is required',
        ];

        $validation = Validator::make($data, $input, $messages);

        if ($validation->fails()) {
            $errors = $validation->errors()->all();
            return response()->json(['error' => true, 'message' => $errors], 200);
        }

        $jsonEmails = array_column($data, 'email');

        try {
            $count = 0;
            foreach ($data as $item) {
                if (UserData::updateOrCreate([
                    'email' => $item['email'],
                ], [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'username' => $item['username'],
                    'email' => $item['email'],
                    'address' => json_encode($item['address']),
                    'phone' => $item['phone'],
                    'website' => $item['website'],
                    'company' => json_encode($item['company']),
                ])) $count++;
            }
        } catch (Exception) {
            return response()->json(['error' => true, 'message' => 'Create or Update error'], 200);
        }

        try {
            $usersToDelete = UserData::whereNotIn('email', $jsonEmails)->delete();
        } catch (Exception) {
            return response()->json(['error' => true, 'message' => 'Soft deleting error'], 200);
        }

        $message = $count . ' users synchronized successfully' .
            ($usersToDelete > 0 ? ', ' . $usersToDelete . ' users was soft deleting' : '');

        Log::info($message);

        return response()->json(['success' => true, 'message' => $message], 200);
    }
}
