<?php

$app->on('cockpit.rest.init', function ($routes) {
  $routes['customers'] = 'NetSuite\\Controller\\CustomersApi';
});