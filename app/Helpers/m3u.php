<?php

declare(strict_types=1);

namespace App\Helpers;

use Generator;

/**
 * Class m3u
 *
 * @package App\Helpers
 */
class m3u
{
    private const REGEX = '/#EXTINF:(.+?)[,]\s?(.+?)[\r\n]+?((?:https?|rtmp):\/\/(?:\S*?\.\S*?)(?:[\s)\[\]{};"\'<]|\.\s|$))/';
    private const ATTRIBUTE_REGEX = '/([a-zA-Z0-9\-]+?)="([^"]*)"/';

    /**
     * @var string
     */
    private string $source;

    /**
     * @var array
     */
    private array $items;

    /**
     * m3u constructor.
     *
     * @param string $source
     */
    public function __construct(string $source)
    {
        ini_set('memory_limit', '2G');
        ini_set('max_execution_time', '0');
        $this->getSource($source);
        $this->clean();
        $this->gatherData();
    }

    /**
     * @param string $source
     */
    private function getSource(string $source): void
    {
        $this->source = file_get_contents($source);
    }

    /**
     * @return void
     */
    private function clean(): void
    {
        $this->source = str_replace('group-title', 'tvgroup', $this->source);
        $this->source = str_replace('tvg-', 'tv', $this->source);
    }

    /**
     * @return Generator|null
     */
    private function getItems(): ?Generator
    {
        preg_match_all(self::REGEX, $this->source, $matches);

        foreach ($matches[0] as $match) {
            yield $match;
        }
    }

    /**
     * @return void
     */
    private function gatherData(): void
    {
        $counter = 0;
        foreach ($this->getItems() as $item) {
            preg_match(self::REGEX, $item, $matchList);
            $mediaURL = preg_replace("/[\n\r]/", '', $matchList[3]);
            $mediaURL = preg_replace('/\s+/', '', $mediaURL);

            $newItem = [
              'id' => ++$counter,
              'tvtitle' => $matchList[2],
              'tvmedia' => $mediaURL,
            ];

            preg_match_all(self::ATTRIBUTE_REGEX, $item, $matches, PREG_SET_ORDER);

            foreach ($matches as $match) {
                $newItem[$match[1]] = $match[2];
            }

            $this->items[] = $newItem;
        }
    }

    /**
     * @return array
     */
    public function getMedia(): array
    {
        return $this->items;
    }

    /**
     * @return Generator|null
     */
    public function yieldMedia(): ?Generator
    {
        foreach ($this->items as $item) {
            yield $item;
        }
    }
}
