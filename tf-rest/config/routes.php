<?php

return [
  "feedback/*" => \TFRest\Router\Feedback::class,
  "orders/*" => \TFRest\Router\Order::class,
  "case*" => \TFRest\Router\CaseRouter::class,
  "service*" => \TFRest\Router\ServiceRouter::class
];