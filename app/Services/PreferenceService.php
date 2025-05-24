<?php

namespace App\Services;

use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;
use MongoDB\Driver\BulkWrite;
use MongoDB\BSON\UTCDateTime;

class PreferenceService{
    
    private Manager $manager;
    private string $namespace = "ecoride.preferences";

    public function __construct()
{
    $uri = $_ENV['MONGO_URI'] ?? 'mongodb://localhost:27017';
    $this->manager = new Manager($uri);
}

    /**
     * Get preferences by vehicle ID
     */

    public function getPreferencesByVehicle(int $vehicleId): ?array
    {
        $filter = ['vehicle_id' => $vehicleId];
        $query = new Query($filter);

        $cursor = $this->manager->executeQuery($this->namespace, $query);
        $results = iterator_to_array($cursor);

        if (empty($results)) {
            return null;
        }

        $doc = $results[0];
        return isset($doc->preferences) ? (array) $doc->preferences : [];
    }

    /**
     * Save preferences in MongoDB
     */
    public function savePreferences(int $vehicleId, array $prefs): void
    {
        // Vérifie si le document existe
        $existing = $this->getPreferencesByVehicle($vehicleId);

        $bulk = new BulkWrite();

        if ($existing) {
            $bulk->update(
                ['vehicle_id' => $vehicleId],
                ['$set' => [
                    'preferences' => $prefs,
                    'updated_at' => new UTCDateTime()
                ]],
                ['multi' => false, 'upsert' => false]
            );
        } else {
            $bulk->insert([
                'vehicle_id' => $vehicleId,
                'preferences' => $prefs,
                'created_at' => new UTCDateTime()
            ]);
        }

        $this->manager->executeBulkWrite($this->namespace, $bulk);
    }

}