<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IslamicShortStoryRequest;
use App\Models\IslamicShortStory;
use App\Services\islamicShortStoryServices;
use App\Traits\Jsonify;
use Exception;
use Illuminate\Http\Request;

class IslamicShortStoryController extends Controller
{
    use Jsonify;

    private $islamicShortStoryServices;

    public function __construct(islamicShortStoryServices $islamicShortStoryServices)
    {
        parent::__permissions('islamic_short_stories');
        $this->islamicShortStoryServices = $islamicShortStoryServices;
    }

    public function index(Request $request)
    {
        try {
            $islamicShortStory = $this->islamicShortStoryServices->search($request->all());

            return self::jsonSuccess(data: $islamicShortStory);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function create()
    {
    }

    public function store(IslamicShortStoryRequest $request)
    {
        try {
            $islamicShortStory = $this->islamicShortStoryServices->create($request);

            return self::jsonSuccess(message: 'Story saved successfully!', data: $islamicShortStory);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function show(IslamicShortStory $islamicShortStory)
    {
        try {
            $islamicShortStory = $this->islamicShortStoryServices->show($islamicShortStory->id);

            return self::jsonSuccess(message: 'Story Retrived successfully!', data: $islamicShortStory);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function edit(IslamicShortStory $islamicShortStory)
    {
    }

    public function update(IslamicShortStoryRequest $request, IslamicShortStory $islamicShortStory)
    {
        try {
            $islamicShortStory = $this->islamicShortStoryServices->update($request, $islamicShortStory);

            return self::jsonSuccess(message: 'Story updated successfully!', data: $islamicShortStory);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function destroy(IslamicShortStory $islamicShortStory)
    {
        try {
            $islamicShortStory = $islamicShortStory->delete();

            return self::jsonSuccess(message: 'Story deleted successfully!', data: $islamicShortStory);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }
}
