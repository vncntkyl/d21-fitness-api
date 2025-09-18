<?php

require_once __DIR__ . "/controller.php";
class MembershipController extends Controller
{
    public function get()
    {
        return $this->getRecords("memberships");
    }

    public function getOne($id)
    {
        $results = $this->getRecords("memberships", ["ID"], [$id], "one");
        return $results;
    }

    public function add($data = [])
    {
        try {

            extract($data);

            $membership_id = $this->addRecords("memberships", ['name', 'description', 'amount', 'payment_mode', 'status'], [$name, $description, $amount, $payment_mode, 1]);

            $new = $this->getOne($membership_id);
            return $this->send(["message" => "Membership plan created successfully", "data" => $new]);
        } catch (Exception $e) {
            $this->send(["error" => $e->getMessage()], 400);
        }
    }
    public function edit($id, $columns, $values)
    {
        if (
            $this->editRecords(
                "memberships",
                $columns,
                $values,
                ["ID"],
                [$id]
            )
        )
            return $this->send(["message" => "Membership plan updated succesfully"]);
    }
}