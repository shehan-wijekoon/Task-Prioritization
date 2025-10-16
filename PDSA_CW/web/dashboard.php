<?php

use Services\TaskScheduler;


require_once __DIR__ . '/../src/Services/TaskScheduler.php';


session_start();


// Initialize the scheduler and store it in the session
if (!isset($_SESSION['scheduler'])) {
    $_SESSION['scheduler'] = new TaskScheduler();
}
$scheduler = $_SESSION['scheduler'];


// --- HANDLE FORM SUBMISSION ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addTask'])) {
        
        $name = $_POST['name'] ?? '';
        $level = (int)($_POST['level'] ?? 1);
        $time = (float)($_POST['time'] ?? 0);
        
        if ($name && $time > 0) {
            // This calls the addTask method, which uses the MaxHeap's O(log n) insert.
            $scheduler->addTask($name, $level, $time);
            
            header('Location: index.php');
            exit;
        }
    } elseif (isset($_POST['completeTask'])) {
        
        // This calls getNextTaskToWorkOn, which uses the MaxHeap's O(log n) extractMax.
        $completedTask = $scheduler->getNextTaskToWorkOn();
        if ($completedTask) {
            $_SESSION['message'] = "✅ Task Completed: {$completedTask->name} (Priority Key: " . number_format($completedTask->priorityKey, 2) . ")";
        } else {
            $_SESSION['message'] = "The schedule is empty!";
        }
        header('Location: index.php');
        exit;
    }
}


// Clear message after display
$message = $_SESSION['message'] ?? null;
unset($_SESSION['message']);


// Retrieve all tasks for display (for demonstration)
$currentTasks = $scheduler->viewAllTasks();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Prioritization Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Task Prioritization Dashboard</h1>

    <?php if ($message): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <div class="container">
        <div class="form-section">
            <h2>Add New Task</h2>
            <form method="POST">
                <input type="text" name="name" placeholder="Task Name (e.g., Finish Report)" required>
                
                <select name="level" required>
                    <option value="3">Level 3 (High Urgency)</option>
                    <option value="2" selected>Level 2 (Medium Urgency)</option>
                    <option value="1">Level 1 (Low Urgency)</option>
                </select>
                
                <input type="number" name="Time" step="0.5" min="0.5" placeholder="Time Required (Hours)" required>
                
                <button type="submit" name="AddTask">Add Task</button>
            </form>
        </div>

        <div class="action-section">
            <h2>Highest Priority Task</h2>
            <form method="POST">
                <?php $nextTask = $scheduler->peekNextTask(); ?>
                
                <?php if ($nextTask): ?>
                    <p><strong>Next Up:</strong> <?php echo $nextTask->__toString(); ?></p>
                    <button type="submit" name="completeTask" class="complete-button">Mark as Complete</button>
                <?php else: ?>
                    <p>The queue is empty! Time for a break. </p>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="heap-display">
        <h2>All Scheduled Tasks (Priority List)</h2>
        <ol>
            <?php foreach ($currentTasks as $task): ?>
                <li><?php echo $task->__toString(); ?></li>
            <?php endforeach; ?>
        </ol>
    </div>

</body>
</html>