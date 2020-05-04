<?php

/*
Welcome to Dave-Smith Johnson & Son family bank!

This is a tool to assist with scam baiting, especially with scammers attempting to
obtain bank information or to attempt to scam you into giving money.

This tool is licensed under the MIT license (copy available here https://opensource.org/licenses/mit), so it
is free to use and change for all users. Scam bait as much as you want!

This project is heavily inspired by KitBoga (https://youtube.com/c/kitbogashow) and his LR. Jenkins bank.
I thought that was a very cool idea, so I created my own version. Now it's out there for everyone!

Please, waste these people's time as much as possible. It's fun and it does good for everyone.

*/

/*
    DEFAULT THEME - DSJAS
    =====================

    This is the themeing files included in the default installation of DSJAS.
    It contains HTML and PHP files required to load and display the default theme.

    This file should never be accessed directly, and instead should only be
    required by a file which has already bootstrapped the site.
    This means that your script must have defined the ABSPATH constants
    and preformed other required bootstrapping tasks before the page
    can be displayed.


    For more information of theming and creating your own themes, please refer to the
    API documentation for themes and plugins.
*/

require(ABSPATH . INC . "api/theme/General.php");
require(ABSPATH . INC . "api/theme/Accounts.php");
require(ABSPATH . INC . "api/theme/Dashboard.php");
require(ABSPATH . INC . "api/theme/Security.php");

// Theme entry point
function getTheme()
{ ?>

    <body>
        <?php require(ABSPATH . "/admin/site/UI/default/components/DashboardNav.php"); ?>

        <?php if (isset($_GET["transferError"])) { ?>
            <div class="alert alert-danger">
                <p><strong>Transfer failed</strong> There was an error while attempting to perform that transaction. Please try again later or contact support.
                    <i>Your account has not been charged</i></p>
            </div>
        <?php } ?>

        <?php if (isset($_GET["transferSuccess"])) { ?>
            <div class="alert alert-success">
                <p><strong>Transfer succeeded</strong> The transfer has been processed and has completed successfully, transferring <?php echo ("$" . htmlentities($_GET["amount"])); ?>.
                    Your new account balance is <strong><?php echo (getDisplayBalance($_GET["originAccount"])); ?></strong>
            </div>
        <?php } ?>

        <div class="jumbotron">

            <h1 class="display-4">Make a transfer</h1>
            <p class="lead">Fill in the form below to transfer money between your accounts</p>
            <hr class="my-4">

            <form style="margin-top: 15px" action="/user/transfer.php" method="GET">
                <?php getCSRFForm(); ?>

                <input type="text" style="visibility: hidden; position: absolute" name="performTransfer">

                <div class="form-group row">
                    <label for="originAccount" class="col-sm-2 col-form-label">Origin account: </label>
                    <div class="col-sm-10">
                        <select type="number" name="originAccount" class="form-control" id="originAccount" required>
                            <?php
                            foreach (getAccountsArray() as $account) { ?>
                                <option value="<?php echo ($account["account_identifier"]) ?>"><?php echo ($account["account_name"]); ?></option>
                            <?php }
                            ?>
                        </select>
                        <small class="form-text text-muted">
                            The account <strong>from</strong> which you wish to transfer
                        </small>
                    </div>
                </div>


                <div class="form-group row">
                    <label for="destinationAccount" class="col-sm-2 col-form-label">Destination account:</label>
                    <div class="col-sm-10">
                        <select type="number" name="destinationAccount" class="form-control" id="destinationAccount" required>
                            <?php
                            foreach (getAccountsArray() as $account) { ?>
                                <option value="<?php echo ($account["account_identifier"]) ?>"><?php echo ($account["account_name"]); ?></option>
                            <?php }
                            ?>
                        </select>
                        <small class="form-text text-muted">
                            The account <strong>to</strong> which you wish to transfer
                        </small>
                    </div>
                </div>


                <div class="input-group mb-3 align-left">
                    <label for="amount" class="col-sm-2 col-form-label">Amount:</label>
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" class="form-control" name="amount" id="amount" min="0" step="0.01" required>
                </div>

                <a class="form-text" data-toggle="collapse" href="#descriptionCollapse">Add a memo</a>

                <div class="collapse" id="descriptionCollapse">
                    <label for="description" class="col-sm-2 col-form-label">Memo:</label>
                    <textarea type="text" class="form-control" name="description" id="description"></textarea>
                </div>


                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary mt-4">Transfer</button>
                        <p class="spacer"></p>
                        <small class="text-danger text-small"><strong>Warning:</strong> Transfers are not reversible and can only be disputed within an hour of processing.
                            Please be sure before you transfer.</small>
                    </div>
                </div>
            </form>
        </div>
    </body>
<?php }