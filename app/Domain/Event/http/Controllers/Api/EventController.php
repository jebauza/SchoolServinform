<?php
namespace Domain\Event\http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = collect([]);

        for ($i=1; $i < 10; $i++) {
            $response = Http::get("https://www.zaragoza.es/sede/servicio/monumento/$i.json");

            if ($response->successful()) {
                $events->push([
                    'id' => $response->json()['id'],
                    'title' => $response->json()['title'],
                    'description' => $response->json()['description'],
                    'image' => $response->json()['image'],
                    'links' => $response->json()['links'],
                    'sameAs' => $response->json()['sameAs'],
                ]);
            }
        }

        return response()->json($events, 200);
    }
}
