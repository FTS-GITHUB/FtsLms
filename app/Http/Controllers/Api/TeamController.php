<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamRequest;
use App\Models\Team;
use App\Services\TeamServices;
use App\Traits\Jsonify;
use Exception;

class TeamController extends Controller
{
    /**
     * Helper method for response
     */
    use Jsonify;

    /**
     * global variable which is used to entire class function
     *
     * @var [type]
     */
    private $teamServices;

    /**
     * contructor method for loading permissions and services
     *
     * @param  TeamServices  $teamServices
     */
    public function __construct(TeamServices $teamServices)
    {
        parent::__permissions('teams');
        $this->teamServices = $teamServices;
    }

    /**
     * getting all teams data from database
     *
     * @param  TeamRequest  $request
     * @return void
     */
    public function index(TeamRequest $request)
    {
        try {
            $data = $this->teamServices->search($request->all());

            return self::jsonSuccess(data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function create()
    {
    }

    /**
     * create a new team
     *
     * @param  TeamRequest  $request
     * @return void
     */
    public function store(TeamRequest $request)
    {
        try {
            $data = $this->teamServices->create($request);

            return self::jsonSuccess(message: 'data saved successfully', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * single record display
     *
     * @param  Team  $team
     * @return void
     */
    public function show(Team $team)
    {
        try {
            $data = $this->teamServices->show($team);

            return self::jsonSuccess(message: '', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    public function edit(Team $team)
    {
    }

    /**
     * update team record
     *
     * @param  TeamRequest  $request
     * @param  Team  $team
     * @return void
     */
    public function update(TeamRequest $request, Team $team)
    {
        try {
            $data = $this->teamServices->update($team, $request);

            return self::jsonSuccess(message: 'data updated', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }

    /**
     * delete data from database
     *
     * @param  Team  $team
     * @return void
     */
    public function destroy(Team $team)
    {
        try {
            $data = $this->teamServices->delete($team);

            return self::jsonSuccess(message: 'data deleted', data: $data);
        } catch (Exception $exception) {
            return self::jsonError($exception->getMessage());
        }
    }
}
