<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Hall;
use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $film = Film::firstWhere('id', $request->film_id);

        $start_session = $request->start_session;
        $finish_session = $start_session + $film->duration;

         $sessions = Session::where('hall_id', $request->hall_id)->get();

         foreach ($sessions as $session) {
             if ($start_session >= $session->start_session && $start_session <= $session->finish_session ) {
                 return response()->json([
                     "status"=>"error",
                     "data"=>'время пересекается с началом сессии',
                     ], 201);
             }
             if ($finish_session >= $session->start_session && $finish_session <= $session->finish_session ) {
                 return response()->json([
                     "status"=>"error",
                     "data"=>'время пересекается с концом сессии',
                     ], 201);
             }
         }

        $newSession = Session::create([
            'hall_id' => $request->hall_id,
            'film_id' => $request->film_id,
            'duraton_session' => $film->duration,
            'start_session' => $start_session,
            'finish_session' => $finish_session,
        ]);


        $newSessionsList = Session::where('hall_id', $request->hall_id)->get();
        return response()->json([
            "status"=>"success",
            "data"=>$newSessionsList,
            ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Index\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return Session::where('hall_id', $id)->get();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Session  $session
    * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $hall_id = Session::firstWhere('id', $id)->hall_id;
        if (!Session::destroy($id)) {
            return response('not found', 404);
        }
        $newSeelionList = Session::where('hall_id', $hall_id)->get();

        return response()->json([
            "status" => "success",
            "data" => $newSeelionList,
        ],201);
    }
}
