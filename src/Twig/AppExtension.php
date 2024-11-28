<?php 
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigFilter;
use Twig\TwigTest;

class AppExtension extends AbstractExtension
{
    // Déclarer une fonction Twig
    public function getFunctions(): array
    {
        return [
            new TwigFunction('format_date', [$this, 'formatDate']),
        ];
    }

    public function formatDate(\DateTime $date, string $format = 'd-m-Y'): string
    {
        return $date->format($format);
    }

    // Déclarer un filtre Twig
    public function getFilters(): array
    {
        return [
            new TwigFilter('truncate', [$this, 'truncate']),
        ];
    }

    public function truncate(string $value, int $limit = 30): string
    {
        if (strlen($value) <= $limit) {
            return $value;
        }

        return substr($value, 0, $limit) . '...';
    }

    // Déclarer un test Twig
    public function getTests(): array
    {
        return [
            new TwigTest('high_priority', [$this, 'isHighPriority']),
        ];
    }

    public function isHighPriority(array $task): bool
    {
        return $task['priority'] === 'high';
    }
}
