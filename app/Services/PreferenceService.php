<?php

namespace App\Services;

use Exception;
use MongoDB\Client;
use MongoDB\Collection;
use MongoDB\BSON\UTCDateTime;

class PreferenceService{
    
    private Collection $collection;

    public function __construct()
    {
        $host = $_ENV['MONGO_HOST'] ?? 'localhost';
        $port = $_ENV['MONGO_PORT'] ?? '27017';
        $user = $_ENV['MONGO_USER']?? '';
        $pass = urlencode($_ENV['MONGO_PASS'] ?? '');
        $auth = $_ENV['MONGO_AUTH_SOURCE'] ?? 'admin';
        $db = $_ENV['MONGO_DB'] ?? 'test';

        $uri = "mongodb://$user:$pass@$host:$port/?authSource=$auth";

        try {
            $client = new Client($uri);
            $this->collection = $client->$db->preferences;
        } catch (Exception $e) {
            die('Connexion MongoDB échouée : ' . $e->getMessage());
        }
    }

    /**
     * Get preferences by vehicle ID
     */

    public function getPreferencesByVehicle(int $vehicleId): ?array
    {
        $document = $this->collection->findOne(['vehicle_id' => $vehicleId]);

        if(!$document){
            return null;
        }

        if (isset($document['preferences'])) {
            return (array) $document['preferences'];
        }

        return [];
    }

    /**
     * Save preferences in MongoDB
     */

    public function savePreferences(int $vehicleId, array $prefs): void
    {
        $existing = $this->collection->findOne(['vehicle_id' => $vehicleId]);

        if($existing){
            $this->collection->updateOne(
                ['vehicle_id' => $vehicleId],
                [
                    '$set' => [
                        'preferences' => $prefs,
                        'updated_at' => new UTCDateTime()
                    ]
                ]
            );
        } else {
            $this->collection->insertOne([
                'vehicle_id' => $vehicleId,
                'preferences' => $prefs,
                'created_at' => new UTCDateTime()
            ]);
        }
    }

}