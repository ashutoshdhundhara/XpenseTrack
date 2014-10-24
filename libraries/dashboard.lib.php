<?php
/**
 * Contains functions required on dashboard page.
 */

if (! defined('XpenseTrack')) {
    exit;
}

function XT_getHtmlMessageBox($msg)
{
    $retval = '';
    if (empty($msg)) {
        $msg = 'Everything seems to be in order in this month :-)';
        if (XT_getCurrentBalance($_SESSION['login_id']) < 1000) {
            $msg = 'Your balance is low :-(';
        }
    }
    $retval .= XT_Message::notice($msg);

    return $retval;
}

function XT_getHtmlDashboardContent()
{
    $retval = '<table class="dashboard_content">'
        . '<tr style="border-bottom: 1px dotted ">'
        . '<th style="width: 20%; border-right: 1px dotted rgba(0,0,0,0.6);">View Expenses By : </th>'
        . '<th style="width: 60%; border-right: 1px dotted rgba(0,0,0,0.6);">Expenses : </th>'
        . '<th style="width: 20%;">Balance : </th>'
        . '</tr>'
        . '<tr>'
        . XT_getHtmlLeftPane()
        . XT_getHtmlMiddlePane()
        . XT_getHtmlRightPane()
        . '</tr>'
        . '</table>';

    return $retval;
}

function XT_getHtmlMiddlePane()
{
    $year = '---';
    $month = '---';
    $type = '---';
    if (isset($_REQUEST['expense_year'])) {
        $year = $_REQUEST['expense_year'];
    }
    if (isset($_REQUEST['expense_month'])) {
        $month = $_REQUEST['expense_month'];
    }
    if (isset($_REQUEST['expense_type'])) {
        $type = $_REQUEST['expense_type'];
    }

    $expenses = XT_getExpenses($_SESSION['login_id'], $year, $month, $type);

    $retval = '<td style="text-align: center;">';

    if ($expenses->rowCount() == 0) {
        $retval .= 'No Expenses to display!';
    } else {
        $odd = true;
        $class = 'odd';
        $retval .= '<table class="expenses_list">'
            . '<tr>'
            . '<th>Amount</th>'
            . '<th>Type</th>'
            . '<th>Date</th>'
            . '<th>Options</th>'
            . '</tr>';
        while ($row = $expenses->fetch()) {
            $retval .= '<tr class="' . $class . '">'
                . '<td>' . $row['expense_amount'] . '</td>'
                . '<td>' . $row['expense_type'] . '</td>'
                . '<td>' . $row['expense_date'] . '</td>'
                . '<td><a href="dashboard.php?delete_expense=1&expense_id=' 
                . $row['expense_id'] 
                . '&expense_amount=' . $row['expense_amount'] . '">Delete</a></td>'
                . '</tr>';
            if ($odd) {
                $class = 'odd';
            } else {
                $class = 'even';
            }

            $odd = !$odd;
        }
        $retval .= '</table>';
    }

    $retval .= '</td>';

    return $retval;
}

function XT_getHtmlRightPane()
{
    $retval = '<td style="text-align: center;">';
    $retval .= 'Your current Balance is :<strong> &#8377; '
        . XT_getCurrentBalance($_SESSION['login_id']) 
        . '</strong>'
        . '<form action="" method="POST">'
        . '<input type="hidden" name="export_expenses" value="true" />'
        . '<button id="export_expenses">Export</button>'
        . '</form>';
    $retval .= '</td>';

    return $retval;
}

function XT_getHtmlLeftPane()
{
    $retval = '<td><form action="" method="POST" id="view_by_list_form">'
        . '<ul class="view_by_list">'
        . '<li>' . XT_getHtmlYearList() . '</li>'
        . '<li>' . XT_getHtmlMonthList() . '</li>'
        . '<li>' . XT_getHtmlTypeList() . '</li>'
        . '<li style="text-align: center;"><button>View</button></li></form>'
        . '<li style="text-align: center;"><button id="add_expense">Add Expense</button></li>'
        . '</ul>'
        . '</td>';

    return $retval;
}

function XT_getHtmlYearList()
{
    $retval = '<select name="expense_year">'
        . '<option value="---">Select Year</option>'
        . '<option value="2014">2014</option>'
        . '<option value="2013">2013</option>'
        . '<option value="2012">2012</option>'
        . '</select>';

    return $retval;
}

function XT_getHtmlMonthList()
{
    $retval = '<select name="expense_month">'
        . '<option value="---">Select Month</option>'
        . '<option value="1">January</option>'
        . '<option value="2">Febraury</option>'
        . '<option value="3">March</option>'
        . '<option value="4">April</option>'
        . '<option value="5">May</option>'
        . '<option value="6">June</option>'
        . '<option value="7">July</option>'
        . '<option value="8">August</option>'
        . '<option value="9">September</option>'
        . '<option value="10">October</option>'
        . '<option value="11">November</option>'
        . '<option value="12">December</option>'
        . '</select>';

    return $retval;
}

function XT_getHtmlTypeList()
{
    $retval = '<select name="expense_type">'
        . '<option value="---">Select Type</option>'
        . '<option value="FOOD">Food</option>'
        . '<option value="FEES">Fees</option>'
        . '<option value="FUN">Fun</option>'
        . '<option value="DEBT">Debt</option>'
        . '</select>';

    return $retval;
}

?>