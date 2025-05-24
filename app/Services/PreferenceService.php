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
    $uri = $_ENV['MONGO_URI'] ?? 'mongodb://localhost:27017';
    $client = new Client($uri);
    $db = $client->ecoride;
    $this->collection = $db->preferences;
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