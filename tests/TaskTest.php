<?php

class TaskTest extends \Tests\TestCase
{
    public function testFetchAllTasks()
    {
        $response = $this->get('/tasks');
        $response->assertResponseStatus(200);
    }

    public function testFetchTask()
    {
        $response = $this->get('/tasks/1');
        $response->assertResponseStatus(200);
    }

    public function testFetchTaskFailure()
    {
        $response = $this->get('/tasks/100');
        $response->assertResponseStatus(404);
    }

    public function testCreateTask()
    {
        $response = $this->call('POST', '/tasks', [], [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'title' => 'Test task 2',
            'description' => 'This is a test task',
            'status' => 'PENDING',
            'due_date' => '2024-12-31'
        ]));

        // Check the response status
        $this->assertEquals(201, $response->status());
    }

    public function testUpdateTask()
    {
        $response = $this->put('/tasks/1', [], [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'title' => 'Test Task Updated',
            'description' => 'This is a test task updated',
            'status' => 'COMPLETED',
            'due_date' => '2021-12-31'
        ]));
        $response->assertResponseStatus(200);
    }

    public function testUpdateTaskFailure()
    {
        $response = $this->put('/tasks/100', [], [], [],['CONTENT_TYPE' => 'application/json'], json_encode([
            'title' => 'Test Task Updated',
            'description' => 'This is a test task updated',
            'status' => 'COMPLETED',
            'due_date' => '2021-12-31'
        ]));
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
