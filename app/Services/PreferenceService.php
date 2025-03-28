<?php

namespace App\Services;

use MongoDB\Client;
use MongoDB\Collection;
use MongoDB\BSON\UTCDateTime;

class PreferenceService{
    
    private Collection $collection;

    public function __construct()
    {
        $client = new Client('mongodb://mongo_ecoride:Is%40bel1410@mongodb:27017/?authSource=admin');
        $this->collection = $client->ecoride->preferences;
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

        return $document['preferences'] ?? [];
    }

    /**
     * Save preferences in MongoDB
     */

    public function saveCollection(int $vehicleId, array $prefs): void
    {
        $this->collection->insertOne([
            'vehicle_id' => $vehicleId,
            'preferences' => $prefs,
            'created_at' => new UTCDateTime()
        ]);
    }

}