<?php

namespace Messerli90\Ghost;

use Illuminate\Support\Facades\Http;

class Ghost
{
    public string $resource = "posts";
    public string $resourceId = "";
    public string $resourceSlug = "";
    public string $includes = "";
    public string $fields = "";
    public string $formats = "";
    public string $limit = "";
    public string $page = "";
    public string $order = "";
    private string $key;
    private string $domain;
    private string $version;

    public function __construct(string $key, string $domain, string $version)
    {
        $this->key = $key;
        $this->domain = $domain;
        $this->version = $version;
    }

    public function all(): array
    {
        return $this->limit('all')->get();
    }

    public function get(): array
    {
        $response = Http::get($this->make());

        if (in_array($response->status(), [404, 422])) {
            return ['posts' => []];
        }

        return $response->json($this->resource);
    }

    public function paginate($limit = null): array
    {
        if (isset($limit)) {
            $this->limit = $limit;
        }

        $response = Http::get($this->make());

        if (in_array($response->status(), [404, 422])) {
            return ['posts' => []];
        }

        return $response->json();
    }

    public function make(): string
    {
        return sprintf(
            "%s/ghost/api/v%s/content/%s/?%s",
            rtrim($this->domain, '/'),
            $this->version,
            $this->buildEndpoint(),
            $this->buildParams()
        );
    }

    protected function buildEndpoint(): string
    {
        $endpoint = $this->resource;
        if (! empty($this->resourceId)) {
            $endpoint .= "/{$this->resourceId}";
        } elseif (! empty($this->resourceSlug)) {
            $endpoint .= "/slug/{$this->resourceSlug}";
        }

        return $endpoint;
    }

    protected function buildParams(): string
    {
        $params = [
            'key' => $this->key,
            'include' => $this->includes ?: null,
            'fields' => $this->fields ?: null,
            'formats' => $this->formats ?: null,
            'limit' => $this->limit ?: null,
            'page' => $this->page ?: null,
            'order' => $this->order ?: null,
        ];

        return http_build_query($params);
    }

    /**
     * Limit how many records are returned at once
     *
     * @param int|string $limit
     *
     * @return $this
     */
    public function limit($limit): Ghost
    {
        $this->limit = strval($limit);

        return $this;
    }

    public function setResource(string $resource): Ghost
    {
        $this->resource = $resource;

        return $this;
    }

    public function posts(): Ghost
    {
        $this->resource = 'posts';

        return $this;
    }

    public function authors(): Ghost
    {
        $this->resource = 'authors';

        return $this;
    }

    public function tags(): Ghost
    {
        $this->resource = 'tags';

        return $this;
    }

    public function pages(): Ghost
    {
        $this->resource = 'pages';

        return $this;
    }

    public function settings(): Ghost
    {
        $this->resource = 'settings';

        return $this;
    }

    /**
     * Return resource from ID
     *
     * @param string $id
     *
     * @return array
     */
    public function find(string $id)
    {
        $this->resourceId = $id;

        return $this->get()[0];
    }

    /**
     * Return resource from slug
     *
     * @param string $slug
     *
     * @return array
     */
    public function fromSlug(string $slug): array
    {
        $this->resourceSlug = $slug;

        return $this->get()[0] ?? [];
    }

    /**
     * Alias for Ghost's include
     * Possible includes: authors, tags, count.posts
     *
     * @param string|array ...$includes
     *
     * @return $this
     */
    public function with(...$includes): Ghost
    {
        $includes = collect($includes)->flatten()->toArray();
        $this->includes = implode(',', $includes);

        return $this;
    }

    /**
     * Limit the fields returned in the response object
     *
     * @param string|array ...$fields
     *
     * @return $this
     */
    public function fields(...$fields): Ghost
    {
        $fields = collect($fields)->flatten()->toArray();
        $this->fields = implode(',', $fields);

        return $this;
    }

    /**
     * Optionally request different format for posts and pages
     * Possible formats: html, plaintext
     *
     * @param string $format
     *
     * @return $this
     */
    public function format(string $format): Ghost
    {
        $this->formats = $format;

        return $this;
    }

    public function page(int $page): Ghost
    {
        $this->page = strval($page);

        return $this;
    }

    public function orderBy(string $attr, string $order = "DESC"): Ghost
    {
        $this->order = $attr . "%20" . strtolower($order);

        return $this;
    }
}
