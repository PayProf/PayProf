<?php
namespace App\Traits;

trait HttpResponses {
   
    protected function succes($data, $message = null, $code = 200) {
        // Retourne une réponse JSON avec le statut de réussite, le message et les données
        return response()->json(
            [
                'status' => 'REQUEST WAS SUCCESSFUL',
                'message' => $message,
                'data' => $data
            ],
            $code
        );
    }

    protected function error($data, $message = null, $code) {
        // Retourne une réponse JSON avec le statut d'erreur, le message et les données
        return response()->json(
            [
                'status' => 'ERROR',
                'message' => $message,
                'data' => $data
            ],
            $code
        );
    }
}
