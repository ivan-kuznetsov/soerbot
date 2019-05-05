<?php

namespace SoerBot\Commands\Leaderboard\AdvImplementations;

use SoerBot\Commands\Leaderboard\Exceptions\StoreFileNotFoundException;

class LeaderBoardStoreJSONFile implements LeaderBoardStoreInterface
{
    /**
     * @var string
     */
    protected $file;

    public function __construct($filename = __DIR__ . '/../Store/leaderboard.json')
    {
        $this->file = $filename;
    }

    /**
     * Saves all the data to JSON with pretty print.
     * @param array $data
     * @return bool|int
     */
    public function save(array $data)
    {
        return file_put_contents($this->file, json_encode(array_values($data), JSON_UNESCAPED_UNICODE |
          JSON_PRETTY_PRINT));
    }

    /**
     * Loads data from JSON file.
     * @throws StoreFileNotFoundException
     * @return array|null
     */
    public function load(): ?array
    {
        if (!file_exists($this->file)) {
            throw new StoreFileNotFoundException('File ' . $this->file . ' have not found');
        }

        if (($content = file_get_contents($this->file)) === false) {
            throw new \RuntimeException('Could not read information from  ' . $this->file);
        }

        return json_decode($content, true);
    }
}