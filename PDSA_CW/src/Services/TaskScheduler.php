<?php

namespace Services;

use DataStructures\MaxHeap;
use DataStructures\Task;


require_once __DIR__ . '/../DataStructures/MaxHeap.php';
require_once __DIR__ . '/../DataStructures/Task.php';

class TaskScheduler {
    
    private MaxHeap $taskQueue;

    public function __construct() {
        $this->taskQueue = new MaxHeap();
    }

    
    public function addTask(string $name, int $level, float $timeRequiredHours): void {
        
        $newTask = new Task($name, $level, $timeRequiredHours);
        
        
        $this->taskQueue->insert($newTask);
    }

    
    public function getNextTaskToWorkOn(): ?Task {
        
        return $this->taskQueue->extractMax();
    }
    
    
    public function peekNextTask(): ?Task {
        return $this->taskQueue->peekMax();
    }
    
    
    public function viewAllTasks(): array {
        
        return $this->taskQueue->getHeapArray();
    }
}