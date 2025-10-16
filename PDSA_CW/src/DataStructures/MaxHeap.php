<?php

namespace DataStructures;


require_once 'Task.php'; 

class MaxHeap {
    
    private array $heap; 

    public function __construct() {
        $this->heap = [];
    }
    
    public function isEmpty(): bool {
        return empty($this->heap);
    }

    
    public function insert(Task $task): void {
        $this->heap[] = $task;
        $this->heapifyUp(count($this->heap) - 1);
    }

    
    public function extractMax(): ?Task {
        if ($this->isEmpty()) {
            return null;
        }

        
        $max = $this->heap[0];
        $lastIndex = count($this->heap) - 1;

        
        $this->heap[0] = $this->heap[$lastIndex];

        
        array_pop($this->heap);

        
        $this->heapifyDown(0);

        return $max;
    }

    
    public function peekMax(): ?Task {
        return $this->isEmpty() ? null : $this->heap[0];
    }
    
    
    private function heapifyUp(int $index): void {
        $parentIndex = floor(($index - 1) / 2);
        
        while ($index > 0 && $this->heap[$index]->priorityKey > $this->heap[$parentIndex]->priorityKey) {
            // Swap
            [$this->heap[$index], $this->heap[$parentIndex]] = [$this->heap[$parentIndex], $this->heap[$index]];
            
            // Move up
            $index = $parentIndex;
            $parentIndex = floor(($index - 1) / 2);
        }
    }

    
    private function heapifyDown(int $index): void {
        $size = count($this->heap);

        do {
            $initialMaxIndex = $index;
            $leftChild = 2 * $index + 1;
            $rightChild = 2 * $index + 2;
            $maxIndex = $index;

           
            if ($leftChild < $size && $this->heap[$leftChild]->priorityKey > $this->heap[$maxIndex]->priorityKey) {
                $maxIndex = $leftChild;
            }
            if ($rightChild < $size && $this->heap[$rightChild]->priorityKey > $this->heap[$maxIndex]->priorityKey) {
                $maxIndex = $rightChild;
            }

            
            if ($maxIndex !== $index) {
                
                [$this->heap[$index], $this->heap[$maxIndex]] = [$this->heap[$maxIndex], $this->heap[$index]];
                $index = $maxIndex;
            } else {
                break; 
            }
        } while (true);
    }

    
    public function getHeapArray(): array {
        return $this->heap;
    }
}