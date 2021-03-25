<?php

namespace Messerli90\Ghost;

use Illuminate\Support\Facades\Http;

class Ghost
{
    public $resource = "posts";
    public $resourceId;
    public $resourceSlug;
    public $includes;
    public $fields;
    public $formats;
    public $limit;
    public $page;
    public $order;
    private string $key;
    private string $domain;
    private string $version;

    public function __construct($key, $domain, $version)
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
        return Http::get($this->make())->json();
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
        if (isset($this->resourceId)) {
            $endpoint .= "/{$this->resourceId}";
        } elseif (isset($this->resourceSlug)) {
            $endpoint .= "/slug/{$this->resourceSlug}";
        }

        return $endpoint;
    }

    protected function buildParams(): string
    {
        $params = [
            'key' => $this->key,
            'include' => $this->includes ?? null,
            'fields' => $this->fields ?? null,
            'formats' => $this->formats ?? null,
            'limit' => $this->limit ?? null,
            'page' => $this->page ?? null,
            'order' => $this->order ?? null
        ];

        return http_build_query($params);
    }

    /**
     * Limit how many records are returned at once
     *
     * @param $limit
     *
     * @return $this
     */
    public function limit($limit): Ghost
    {
        $this->limit = $limit;
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
        return $this->get()['posts'][0];
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
        return $this->get()['posts'][0];
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
        $this->page = $page;
        return $this;
    }

    public function orderBy(string $attr, string $order = "DESC"): Ghost
    {
        $this->order = $attr . "%20" . strtolower($order);
        return $this;
    }
}
