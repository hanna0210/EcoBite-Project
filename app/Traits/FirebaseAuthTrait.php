<?php

namespace App\Traits;

use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Storage;
use MrShan0\PHPFirestore\FirestoreClient;
use MrShan0\PHPFirestore\Authentication\FirestoreAuthentication;

trait FirebaseAuthTrait
{

    private function getFirebaseFactory()
    {
        try {
            $serviceKeyPath = setting('serviceKeyPath', 'vault/firebase_service.json');
            
            // Try to get the full path to the service account file
            $fullPath = storage_path('app/' . $serviceKeyPath);
            
            // Check if file exists
            if (!file_exists($fullPath)) {
                throw new \Exception(__("Firebase service account file not found at: ") . $fullPath, 1);
            }
            
            // Read file content directly
            $serviceAccountContent = file_get_contents($fullPath);
            
            if (!$serviceAccountContent) {
                throw new \Exception(__("Unable to read Firebase service account file"), 1);
            }
            
            return (new Factory)->withServiceAccount($serviceAccountContent);
        } catch (\Exception $ex) {
            throw new \Exception(__("Firebase setup error: ") . $ex->getMessage(), 1);
        }
    }


    private function getFirebaseMessaging()
    {
        return $this->getFirebaseFactory()->createMessaging();
    }

    private function getFirebaseAuth()
    {
        return $this->getFirebaseFactory()->createAuth();
    }

    private function getFirebaseStore()
    {
        return $this->getFirebaseFactory()->createFirestore();
    }

    private function getFirebaseStoreClient(): FirestoreClient
    {
        $client = new FirestoreClient(setting('projectId', ""), setting('apiKey', ""), [
            'database' => '(default)',
        ]);
        //set auth for client
        $this->firestoreClientAuth($client);
        return $client;
    }


    public function verifyFirebaseIDToken($idTokenString)
    {
        //
        $auth = $this->getFirebaseAuth();
        $verifiedIdToken = $auth->verifyIdToken($idTokenString);
        $uid = $verifiedIdToken->claims()->get('sub');
        return $auth->getUser($uid);
    }

    //firestore 
    public function firestoreClientAuth($firestoreClient)
    {

        $authToken = session('fbToken');
        $authTokenExpiry = session('fbTokenExpiry');

        if (empty($authToken) || empty($authTokenExpiry) || $authTokenExpiry < time()) {
            $uId = "user_id_" . \Auth::id() . "";
            $customToken = $this->getFirebaseAuth()->createCustomToken($uId);
            $signInResult = $this->getFirebaseAuth()->signInWithCustomToken($customToken);
            $authToken = $signInResult->idToken();
            session(['fbToken' => $authToken]);

            //refresh token every 60mins/1hr
            $authTokenExpiry = time() + 3600;
            session(['fbTokenExpiry' => $authTokenExpiry]);
        }

        $auth = new FirestoreAuthentication($firestoreClient);
        $auth->setCustomToken($authToken);
    }
}
