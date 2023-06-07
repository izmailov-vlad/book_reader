<?php

namespace App\Http\ExternalApi;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;

class GoogleBooksApi
{
    private string $apiKey;
    private Client $httpClient;

    public function __construct()
    {
        $this->apiKey = '&key=' . config('constants.google_books.api_key');
        $this->httpClient = new Client(
            [
                'base_uri' => GoogleBooksApiPath::$googleBooksApiBaseHost,
            ]
        );
    }

    /**
     * @throws GuzzleException
     */
    public function getBookByQuery(string $query, int $startIndex, $maxResult): mixed
    {
        $response = $this->httpClient->request(
            'GET',
            GoogleBooksApiPath::$volumes
            . '?q=' . $query
            . '&maxResults=' . $maxResult
            . '&startIndex=' . $startIndex
            . $this->apiKey
        );
        return json_decode($response->getBody(), true);
    }

    /**
     * @throws GuzzleException
     */
    public function getBooksByCategoryName(string $categoryName, int $startIndex, int $maxResult): mixed
    {
        $response = $this->httpClient->request('GET',
            GoogleBooksApiPath::$volumes
            . '?q=Книги жанра ' . $categoryName
            . '&maxResults=' . $maxResult
            . '&startIndex=' . $startIndex
            . $this->apiKey
        );
        return json_decode($response->getBody(), true);
    }

    /**
     * @throws GuzzleException
     */
    public function getBookById(string $bookId): array
    {
        $response = $this->httpClient->request('GET', GoogleBooksApiPath::$volumes . $bookId);
        return json_decode($response->getBody(), true);
    }

    public function getBooksByIds(array $bookIds): array
    {
        $books = [];

        foreach ($bookIds as $id) {
            $requestUrl = GoogleBooksApiPath::$volumes . urlencode($id);

            // Выполнение запроса и обработка ответа
            $response = $this->httpClient->request('GET', $requestUrl);
            $data = json_decode($response->getBody(), true);

            $books[] = $data;
        }

        return $books;
    }
}
