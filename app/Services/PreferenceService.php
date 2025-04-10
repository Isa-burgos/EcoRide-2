<?php

namespace App\Services;

use MongoDB\Client;
use MongoDB\Collection;
use MongoDB\BSON\UTCDateTime;

class PreferenceService{
    
    private Collection $collection;

    public function __construct()
    {
        $host = $_ENV['MONGO_HOST'];
        $port = $_ENV['MONGO_PORT'];
        $user = $_ENV['MONGO_USER'];
        $pass = urlencode($_ENV['MONGO_PASS']);
        $auth = $_ENV['MONGO_AUTH_SOURCE'];
        $db = $_ENV['MONGO_DB'];

        $uri = "mongodb://$user:$pass@$host:$port/?authSource=$auth";

        $client = new Client($uri);
        $this->collection = $client->$db->preferences;
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