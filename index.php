<?php ini_set('display_errors', 'on'); ?>
<?php include_once('header.php'); ?>
<!DOCTYPE html>
<html lang="en">
	
	<head>
		<title><?php echo ucwords($myname); ?></title>

	    <!-- CSS -->
	    <link href="<?php echo "css/bootstrap/bootstrap.css" ?>" rel="stylesheet">
	    <style type="text/css">

			/* Custom page CSS
			-------------------------------------------------- */
			/* Not required for template or sticky footer method. */

      body {
        padding-top: 20px;
        padding-bottom: 40px;
      }

      /* Custom container */
      .container {
        margin: 0 auto;
        max-width: 850px;
      }
      .container > hr {
        margin: 30px 0;
      }

      /* Main marketing message and sign up button */
      .jumbotron {
        margin: 60px 0;
        text-align: center;
      }
      .jumbotron h1 {
        font-size: 72px;
        line-height: 1;
      }
      .jumbotron .btn {
        font-size: 21px;
        padding: 14px 24px;
      }

      /* Supporting marketing content */
      .marketing {
        margin: 60px 0;
      }
      .marketing p + h4 {
        margin-top: 28px;
      }

	    </style>
      <link href="<?php echo "css/bootstrap/bootstrap-responsive.css" ?>" rel="stylesheet">
      <link href="<?php echo "css/style.css" ?>" rel="stylesheet">

	</head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
          <div class="container-fluid">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>

            <a class="brand" href="index.php"><?php echo ucwords($myname); ?></a>

            <div class="nav-collapse collapse">
              <ul class="nav pull-right">
                <li><a href="status.php">Status</a></li>
              </ul>
            </div><!--/.nav-collapse -->

          </div><!--/.container-fluid -->
        </div><!--/.navbar-inner -->
      </div>

      <!-- Begin page content -->
      <div class="container" style="margin-top:60px;">

        <?php if(empty($services)) { ?>

          <div class="jumbotron">
            <h1><?php echo ucwords($myname); ?> Instance</h1>
            <p class="lead">The <?php echo ucwords($myname); ?> instance does not poll any other services. Please update that app.json file to connect to other services.</p>
            <a class="btn btn-large btn-success" href="#"><?php echo ucwords($myname); ?></a>
          </div>

        <?php } ?>

        <?php foreach ($services as $service_name => $details) { ?>
        <div class="accordion" id="accordion-<?php echo $service_name; ?>">

          <div class="accordion-group">                  
            <div class="accordion-heading">              
              <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-<?php echo $service_name; ?>" href="#collapseOne-<?php echo $service_name; ?>">
                <?php echo ucwords($service_name); ?>
              </a> 
            </div>
            <div id="collapseOne-<?php echo $service_name; ?>" class="accordion-body collapse in">
              <div class="accordion-inner">

                <br />                
                <div id="<?php echo $service_name;?>-msg-block">
                  <div class="alert alert-block alert-info">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    Not connected to <?php echo ucwords($service_name); ?> Service
                  </div>
                </div>

              </div>
            </div>
          </div>
                        
          <div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-<?php echo $service_name; ?>" href="#collapseTwo-<?php echo $service_name; ?>">
                  <?php echo ucwords($service_name); ?> Server Details
                </a>
              </div>        
              <div id="collapseTwo-<?php echo $service_name; ?>" class="accordion-body collapse">
                <div class="accordion-inner">
                  <pre>
                    <?php print_r($details['automatic']['ec2']); ?>
                  </pre>
                </div>
              </div>
          </div>
          
        </div>

      <?php } ?>

      <div id="push"></div>
    </div>

    <div id="footer">
      <div class="container">
        <p class="muted credit">Opscode Chef Deployment Demo by <a href="http://jaibapna.com">Jai Bapna</a></p>
      </div>
    </div>



    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>

    <script type="text/javascript">

      var $services = <?php echo json_encode($services); ?>;
      var $self = <?php echo json_encode($self); ?>;
      var $myname = <?php echo json_encode($myname); ?>;
      var $app = <?php echo json_encode($app); ?>;      

      $(document).ready(function() {    

          for (var $service_name in $services) {
            doAjax($service_name);
          }

          function doAjax($service_name) {

            $service_url = $services[$service_name]['automatic']['ec2']['public_ipv4'];
            $url = 'proxy.php?service='+$service_name;
            
            $.ajax({
              url: $url,
              type: 'GET',
              dataType: 'json',
              statusCode: {

                200: function(data) {

                  $class = new Array();
                  $class['Yellow'] = '';
                  $class['Green'] = 'alert-success';
                  
                  $msg = '<div class="alert alert-block ' + $class[data['status']] + '">\
                            <button type="button" class="close" data-dismiss="alert">x</button>\
                            <p>Last Updated: '+ getTime() + '</p>\
                            <p>\
                              Request ID: ' + data['id'] + '<br />\
                              Name: ' + data['name'] + '<br />' +
                              data['message'] + 
                            '</p>\
                          </div>';


                  $('#'+$service_name+'-msg-block').empty().html($msg);

                },
                500: function() {

                  $msg = '<div class="alert alert-block alert-error">\
                            <button type="button" class="close" data-dismiss="alert">x</button>\
                            Cannot connect to service. Internal Service Error.\
                          </div>';

                  $('#'+$service_name+'-msg-block').empty().html($msg);

                },
                404: function() {

                  $msg = '<div class="alert alert-block alert-error">\
                            <button type="button" class="close" data-dismiss="alert">x</button>\
                            Cannot connect to service. Service Not Found.\
                          </div>';

                  $('#'+$service_name+'-msg-block').empty().html($msg);

                }
              },
              complete: function() {
                
                setTimeout(function(){
                  doAjax($service_name);
                },3000);

              }

            });

          }

          function getTime() {
            d = new Date();
            var time = d.toLocaleTimeString();
            return time;
          }


      });

  </script>
  </body>
</html>
