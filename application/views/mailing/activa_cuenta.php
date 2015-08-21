<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width" />
    <title></title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,300' rel='stylesheet' type='text/css'>
    <style type="text/css">
        html, body { width: 100%; height: 100%; }
        body { margin: 0; padding: 0; font-family: "Open Sans", "Helvetica", Arial, sans-serif; }

        p { font-size: 14px; }
        #header h1, #header h2, #header h3, #header h4, #header h5, #header h6 { color: #FFFFFF; }
        h3 { font-weight: 300; }

        /*** Phones ***/
        @media (max-width: 480px) {
            table.container, table.wrapper { width: 100% !important; }
        }
    </style>
</head>
<body>
    <table class="wrapper" width="100%" bgcolor="#2196F3">
        <tr>
            <td align="center">
                <center>
                    <table class="container" id="header" width="600">
                        <tr>
                            <td valign="middle" width="140">
                                <img src="<?php echo base_url('assets/images/logo-white.png'); ?>" alt="Key Panel" width="140" />
                            </td>
                        </tr>
                    </table>
                </center>
            </td>
        </tr>
    </table>

    <table class="wrapper" width="100%">
        <tr>
            <td align="center">
                <center>
                    <table class="container" width="600" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <p><?php echo sprintf(lang('msg_activa_tu_cuenta'),$member['first_name']); ?></p>
                                <p><a href="<?php echo base_url('account/activation/'.$member['token']); ?>">Haz clic aquí para activar tu cuenta</a></p>
                            </td>
                        </tr>
                    </table>
                </center>
            </td>
        </tr>
    </table>
</body>
</html>