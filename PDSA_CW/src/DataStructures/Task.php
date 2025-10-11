<?php

namespace DataStructures;

class Task {
    public string $name;
    public int $urgencyLevel; // 1, 2, or 3
    public float $timeRequiredHours;
    public float $priorityKey;

    public function __construct(string $name, int $level, float $timeRequiredHours) {
        $this->name = $name;
        $this->urgencyLevel = $level;
        $this->timeRequiredHours = $timeRequiredHours;
        
       
        $this->priorityKey = $this->calculatePriorityKey();
    }

    private function calculatePriorityKey(): float {
        
        $baseScore = match ($this->urgencyLevel) {
            1 => 10.0,  // Low
            2 => 20.0,  // Medium
            3 => 30.0,  // High
            default => 10.0,
        };

        
        $timeScore = 1.0 / ($this->timeRequiredHours + 1.0);

        
        return $baseScore + $timeScore;
    }

    public function __toString(): string {
        return "{$this->name} [Level: {$this->urgencyLevel}, Time: {$this->timeRequiredHours}h, Key: " . number_format($this->priorityKey, 2) . "]";
    }
}