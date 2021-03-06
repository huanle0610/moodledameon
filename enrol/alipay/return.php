<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * alipay utility script
 *
 * @package    enrol
 * @subpackage alipay
 * @subpackage file
 * @copyright  hl<huanle0610@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


$id = required_param('id', PARAM_INT);

if (!$course = $DB->get_record("course", array("id"=>$id))) {
    redirect($CFG->wwwroot);
}

$context = get_context_instance(CONTEXT_COURSE, $course->id, MUST_EXIST);

require_login();

// Refreshing enrolment data in the USER session
load_all_capabilities();

if ($SESSION->wantsurl) {
    $destination = $SESSION->wantsurl;
    unset($SESSION->wantsurl);
} else {
    $destination = "$CFG->wwwroot/course/view.php?id=$course->id";
}

if (is_enrolled($context, NULL, '', true)) { // TODO: use real alipay check
    redirect($destination, get_string('paymentthanks', '', $course->fullname));

} else {   /// Somehow they aren't enrolled yet!  :-(
    $PAGE->set_url($destination);
    echo $OUTPUT->header();
    $a = new stdClass();
    $a->teacher = get_string('defaultcourseteacher');
    $a->fullname = format_string($course->fullname);
    notice($errorreason.'<br />'.get_string('paymentsorry', '', $a), $destination);
}


