<?php

require_once __DIR__ . "/controller.php";
class SubscriptionController extends Controller
{
    public function get()
    {
        return $this->getRecords("subscriptions");
    }

    public function getOne($id)
    {
        $results = $this->getRecords("subscriptions", ["ID"], [$id], "one");
        return $results;
    }

    public function add($data = [])
    {
        try {

            extract($data);

            $subscription_id = $this->addRecords("subscriptions", ['name', 'description', 'amount', 'duration', 'payment_mode', 'status'], [$name, $description ?? null, $amount, $duration, $payment_mode, 1]);

            $new = $this->getOne($subscription_id);
            return $this->send(["message" => "Subscription plan created successfully", "data" => $new]);
        } catch (Exception $e) {
            $this->send(["error" => $e->getMessage()], 400);
        }
    }
    public function edit($id, $columns, $values)
    {
        if (
            $this->editRecords(
                "subscriptions",
                $columns,
                $values,
                ["ID"],
                [$id]
            )
        )
            $new = $this->getOne($id);
        return $this->send(["message" => "Subscription plan updated successfully", "data" => $new]);
    }

    public function delete($id)
    {
        if (
            $this->editRecords(
                "subscriptions",
                ["status"],
                [0],
                ["ID"],
                [$id]
            )
        )
            $new = $this->getOne($id);
        return $this->send(["message" => "Subscription plan deleted successfully", "data" => $new]);
    }
}