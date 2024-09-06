<?php

class TaskTestCases extends \Tests\TestCase
{
    public function testFetchAllTasks()
    {
        $response = $this->get('/tasks');
        $response->assertResponseStatus(200);
    }

    public function testFetchTask()
    {
        $response = $this->get('/tasks/4');
        $response->assertResponseStatus(200);
    }

    public function testFetchTaskFailure()
    {
        $response = $this->get('/tasks/100');
        $response->assertResponseStatus(404);
    }

    public function testCreateTask()
    {
        $response = $this->post('/tasks', [
            'title' => 'Test Task',
            'description' => 'This is a test task',
            'status' => 'PENDING',
            'due_date' => '2024-12-31'
        ],['Content-Type' => 'application/json']);
        $response->assertResponseStatus(201);
    }

    public function testUpdateTask()
    {
        $response = $this->put('/tasks/1', [
            'title' => 'Test Task Updated',
            'description' => 'This is a test task updated',
            'status' => 'COMPLETED',
            'due_date' => '2021-12-31'
        ]);
        $response->assertResponseStatus(200);
    }

    public function testUpdateTaskFailure()
    {
        $response = $this->put('/tasks/100', [
            'title' => 'Test Task Updated',
            'description' => 'This is a test task updated',
            'status' => 'COMPLETED',
            'due_date' => '2021-12-31'
        ]);
        $response->assertResponseStatus(404);
    }

    public function testDeleteTask()
    {
        $response = $this->delete('/tasks/1');
        $response->assertResponseStatus(200);
    }

    public function testDeleteTaskFailure()
    {
        $response = $this->delete('/tasks/100');
        $response->assertResponseStatus(404);
    }
}

?>
