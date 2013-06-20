<?php
/*
 * Name: Admin Logout
 * Programmer: Liam Kelly
 * Date: 6/20/13
 */

//log the user out
session_destroy();

header('location: ./?p=logout');
