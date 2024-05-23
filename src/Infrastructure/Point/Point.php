<?php

declare(strict_types=1);

namespace App\Infrastructure\Point;

use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Attribute\Groups;

final readonly class Point implements \JsonSerializable
{
    private function __construct(
        #[OA\Property(type: 'number', format: 'float', maximum: 90, minimum: -90), Groups(['api'])]
        public float $latitude,
        #[OA\Property(type: 'number', format: 'float', maximum: 180, minimum: -180), Groups(['api'])]
        public float $longitude,
    ) {
        if ($latitude < -90 || $latitude > 90) {
            throw new \InvalidArgumentException('Latitude must be between -90 and 90.');
        }

        if ($longitude < -180 || $longitude > 180) {
            throw new \InvalidArgumentException('Longitude must be between -180 and 180.');
        }
    }

    public static function fromCoordinates(float $latitude, float $longitude): self
    {
        return new self($latitude, $longitude);
    }

    public static function fromWKT(string $wkt): self
    {
        $pattern = '/SRID=4326;POINT\(([-+]?[0-9]*\.?[0-9]+) ([-+]?[0-9]*\.?[0-9]+)\)/';

        if (preg_match($pattern, $wkt, $matches)) {
            $longitude = $matches[1];
            $latitude = $matches[2];
        } else {
            throw new \InvalidArgumentException('Invalid WKT format.');
        }

        return new self((float)$latitude, (float)$longitude);
    }

    public function toWKT(): string
    {
        return "SRID=4326;POINT($this->longitude $this->latitude)";
    }

    public function __toString(): string
    {
        return $this->toWKT();
    }

    public function jsonSerialize(): array
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }
}
