<?php
session_start();

require_once "../includes/config.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $sql = "INSERT INTO ccm_replies (question, who_asked, replied_by, reply) VALUES (?, ?, ?, ?)";

  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("iiis", $param_question, $param_sender, $param_advisor, $param_reply);

    $param_question = $_GET["question"];
    $param_sender = $_GET["sender"];
    $param_advisor = $_GET["advisor"];
    $param_reply = trim($_POST["message"]);

    if ($stmt->execute()) {
      $sql2 = "UPDATE ccm_messages SET replied = ? WHERE id = ?";
      if ($stmt2 = $conn->prepare($sql2)) {
        $stmt2->bind_param("ii", $param_replied, $param_question);

        $param_replied = 1;
        $param_question = intval($_GET["question"]);
        if ($stmt2->execute()) {
          header("location: respond_questions.php?advisor=" . $_GET["advisor"] . "&question=" . $_GET["question"] . "&sender=" . $_GET["sender"]);
        }
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }
      $stmt2->close();
    }
  }
  $stmt->close();
}
