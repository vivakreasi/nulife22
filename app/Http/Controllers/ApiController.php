<?php

namespace App\Http\Controllers;

use App\Plan_c_pin;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\FileCookieJar;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;

class ApiController extends Controller
{
    
    public function getMandiri()
    {
        try{
            $http = new Client([
                'base_uri'          => 'http://adsnet.id/',
                'timeout'           => 15.5,
//            'debug'             => true,
            ]);

            $response = $http->request('POST', 'mandiri', [
                'headers'   => [
                    'APIToken'  => '_#xUk3K^5g!FxxB^qgqPun*dAksvq+t5HB=$SPy*vZNB&e!CdZdBYwShNMPReUFw',
                    'Start'     => '2017-03-25',
                    'End'       => '2017-03-25'
                ],
            ]);

            if($response->getStatusCode() == '200') {
                return json_decode($response->getBody()->getContents());
            } elseif ($response->getStatusCode() == '401') {
                return '401';
            } elseif ($response->getStatusCode() == '500') {
                return 'server error';
            }

        } catch (ClientException $e) {
            return $e->getCode();
        } catch (RequestException $e) {
            return $e->getCode();
        } catch (\Exception $e) {
            return $e;
        }

//        $data = collect(json_decode($response->getBody()->getContents(), true));
//        $filtered = $data->filter(function ($value) {
//           return $value[3] > 0;
//        });
//
//        return json_decode($response->getBody()->getContents());
    }
}
