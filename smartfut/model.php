
<!DOCTYPE html>

<html class="no-js">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Examples | Bootbox.js &mdash; alert, confirm and flexible dialogs for the Bootstrap framework</title>

    <script src="model/modernizr-custom.js"></script>

    <link rel="stylesheet" type="text/css" href="model/bootstrap.min.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="model/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="model/animate.min.css" />
    <link rel="stylesheet" type="text/css" href="model/google.prettify.min.css" />

    <link rel="stylesheet" href="model/main.css" />

    <script src="model/scroll-fix.js"></script>
    <script>
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-20517424-8']);
        _gaq.push(['_trackPageview']);
        (function () {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
    </script>
    <!-- Universal Analytics; remove the above script and uncomment this after upgrading -->
    <!--<script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r; i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date(); a = s.createElement(o),
            m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-20517424-8', 'auto');
        ga('send', 'pageview');
    </script>-->

</head>
<body class="bb-js" onload="load()">
    <div class="bb-header bb-header-fixed-navbar">
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-bb-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="fa fa-navicon"></span>
                    </button>
                    <a id=top class="navbar-brand navbar-brand-active" href="./">Bootbox.js</a>
                </div>
                <div class="collapse navbar-collapse navbar-bb-collapse">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="./getting-started.html">Getting Started</a>
                        </li>
                        <li class="dropdown active">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Examples <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="#bb-alert-dialog">Alert</a>
                                </li>
                                <li>
                                    <a href="#bb-confirm-dialog">Confirm</a>
                                </li>
                                <li>
                                    <a href="#bb-prompt-dialog">Prompt</a>
                                </li>
                                <li>
                                    <a href="#bb-custom-dialog">Custom Dialog</a>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <a href="./examples.html">View all</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Documentation <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="./documentation.html#bb-alert-dialog">Alert</a>
                                </li>
                                <li>
                                    <a href="./documentation.html#bb-confirm-dialog">Confirm</a>
                                </li>
                                <li>
                                    <a href="./documentation.html#bb-prompt-dialog">Prompt</a>
                                </li>
                                <li>
                                    <a href="./documentation.html#bb-custom-dialog">Custom Dialog</a>
                                </li>
                                <li>
                                    <a href="./documentation.html#bb-options">Options</a>
                                </li>
                                <li>
                                    <a href="./documentation.html#bb-public-functions">Public Functions</a>
                                </li>
                                <li>
                                    <a href="./documentation.html#bb-notes">Notes</a>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <a href="./documentation.html">View all</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="http://paynedigital.com/bootbox">Writeup</a>
                        </li>
                        <li>
                            <a href="https://github.com/makeusabrew/bootbox">
                                <i class="fa fa-github"></i>
                                Github
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="content" class="bb-docs-header" tabindex="-1">
            <div class="container text-center">
                <div class="bb-masthead">
                    <h1>
                        Examples
                    </h1>
                    <p class="lead">
                        Currently viewing examples for version 4.x.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="content">
            <div class="docs-container">
                <section class="intro">
                    <p>
                        The examples below attempt to demonstrate the myriad ways in which you can use Bootbox.js. Where functionality amongst the dialogs is nearly identical,
                        the example will indicate to which functions the example applies.
                    </p>
                </section>

                <section id="bb-alert-dialog" class="bb-section">
                    <div class="bb-section-header">
                        <div class="pull-right">
                            <a href="./documentation.html#bb-alert-dialog" class="btn btn-link">Documentation</a>
                            |
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#bb-alert-examples" aria-expanded="false" aria-controls="bb-alert-examples">
                                Show / Hide
                            </button>
                        </div>
                        <h2 class="page-header">
                            Alert
                        </h2>
                    </div>
                    <div id="bb-alert-examples" class="collapse in">
                        <div>
                            <ul class="bb-examples-list">
                                <li>
                                    <p class="bb-example">Basic usage</p>
                                    <p>
                                        <button type="button" class="btn btn-primary example-button" data-bb-example-key="alert-default">Run example</button>
                                    </p>
                                    <pre class="prettyprint"><code>bootbox.alert("This is the default alert!");</code></pre>
                                </li>
                                <li>
                                    <p class="bb-example">Basic usage, with callback</p>
                                    <p>
                                        <button type="button" class="btn btn-primary example-button" data-bb-example-key="alert-callback">Run example</button>
                                    </p>
                                    <pre class="prettyprint"><code>bootbox.alert("This is an alert with a callback!", function(){ console.log('This was logged in the callback!'); });</code></pre>
                                </li>
                                <li>
                                    <p class="bb-example">Basic usage, using options object</p>
                                    <p>
                                        <button type="button" class="btn btn-primary example-button" data-bb-example-key="alert-options">Run example</button>
                                    </p>
                                    <pre class="prettyprint linenums"><code>bootbox.alert({
    message: "This is an alert with a callback!",
    callback: function () {
        console.log('This was logged in the callback!');
    }
})</code></pre>
                                </li>
                                <li>
                                    <p class="bb-example">
                                        <span class="pull-right">
                                            Also applies to: <b>Confirm</b>, <b>Prompt</b>, <b>Custom</b>
                                        </span>
                                        Small dialog
                                    </p>
                                    <p>
                                        <button type="button" class="btn btn-primary example-button" data-bb-example-key="alert-small">Run example</button>
                                    </p>
                                    <pre class="prettyprint linenums"><code>bootbox.alert({
    message: "This is the small alert!",
    size: 'small'
});</code></pre>
                                </li>
                                <li>
                                    <p class="bb-example">
                                        <span class="pull-right">
                                            Also applies to: <b>Confirm</b>, <b>Prompt</b>, <b>Custom</b>
                                        </span>
                                        Large dialog
                                    </p>
                                    <p>
                                        <button type="button" class="btn btn-primary example-button" data-bb-example-key="alert-large">Run example</button>
                                    </p>
                                    <pre class="prettyprint linenums"><code>bootbox.alert({
    message: "This is the large alert!",
    size: 'large'
});</code></pre>
                                </li>
                                <li>
                                    <p class="bb-example">
                                        <span class="pull-right">
                                            Also applies to: <b>Confirm</b>, <b>Prompt</b>, <b>Custom</b>
                                        </span>
                                        Custom CSS class
                                    </p>
                                    <p>
                                        <button type="button" class="btn btn-primary example-button" data-bb-example-key="alert-custom-class">Run example</button>
                                    </p>
                                    <pre class="prettyprint linenums"><code>bootbox.alert({
    message: "This is an alert with an additional class!",
    className: 'bb-alternate-modal'
});</code></pre>
                                </li>
                                <li>
                                    <p class="bb-example">
                                        <span class="pull-right">
                                            Also applies to: <b>Confirm</b>, <b>Prompt</b>, <b>Custom</b>
                                        </span>
                                        Dismiss with overlay click
                                    </p>
                                    <p>
                                        <button type="button" class="btn btn-primary example-button" data-bb-example-key="alert-overlay-click">Run example</button>
                                    </p>
                                    <pre class="prettyprint linenums"><code>bootbox.alert({
    message: "This alert can be dismissed by clicking on the background!",
    backdrop: true
});</code></pre>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>


                <section id="bb-confirm-dialog" class="bb-section">
                    <div class="bb-section-header">
                        <div class="pull-right">
                            <a href="./documentation.html#bb-confirm-dialog" class="btn btn-link">Documentation</a>
                            |
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#bb-confirm-examples" aria-expanded="false" aria-controls="bb-confirm-examples">
                                Show / Hide
                            </button>
                        </div>
                        <h2 class="page-header">Confirm</h2>
                    </div>
                    <div id="bb-confirm-examples" class="collapse in">
                        <div>
                            <ul class="bb-examples-list">
                                <li>
                                    <p class="bb-example">Basic usage</p>
                                    <p>
                                        <button type="button" class="btn btn-primary example-button" data-bb-example-key="confirm-default">Run example</button>
                                    </p>
                                    <pre class="prettyprint"><code>bootbox.confirm("This is the default confirm!", function(result){ console.log('This was logged in the callback: ' + result); });</code></pre>
                                </li>
                                <li>
                                    <p class="bb-example">
                                        <span class="pull-right">
                                            Also applies to: <b>Alert</b>, <b>Prompt</b>, <b>Custom</b>
                                        </span>
                                        With alternate button text and color
                                    </p>
                                    <p>
                                        <button type="button" class="btn btn-primary example-button" data-bb-example-key="confirm-options">Run example</button>
                                    </p>
                                    <pre class="prettyprint linenums"><code>bootbox.confirm({
    message: "This is a confirm with custom button text and color! Do you like it?",
    buttons: {
        confirm: {
            label: 'Yes',
            className: 'btn-success'
        },
        cancel: {
            label: 'No',
            className: 'btn-danger'
        }
    },
    callback: function (result) {
        console.log('This was logged in the callback: ' + result);
    }
});</code></pre>
                                </li>
                                <li>
                                    <p class="bb-example">
                                        <span class="pull-right">
                                            Also applies to: <b>Alert</b>, <b>Prompt</b>, <b>Custom</b>
                                        </span>
                                        With icon and button text
                                    </p>
                                    <p>
                                        <button type="button" class="btn btn-primary example-button" data-bb-example-key="confirm-button-text">Run example</button>
                                    </p>
                                    <pre class="prettyprint linenums"><code>bootbox.confirm({
    title: "Destroy planet?",
    message: "Do you want to activate the Deathstar now? This cannot be undone.",
    buttons: {
        cancel: {
            label: '&lt;i class="fa fa-times"&gt;&lt;/i&gt; Cancel'
        },
        confirm: {
            label: '&lt;i class="fa fa-check"&gt;&lt;/i&gt; Confirm'
        }
    },
    callback: function (result) {
        console.log('This was logged in the callback: ' + result);
    }
});</code></pre>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>


                <section id="bb-prompt-dialog" class="bb-section">
                    <div class="bb-section-header">
                        <div class="pull-right">
                            <a href="./documentation.html#bb-prompt-dialog" class="btn btn-link">Documentation</a>
                            |
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#bb-prompt-examples" aria-expanded="false" aria-controls="bb-prompt-examples">
                                Show / Hide
                            </button>
                        </div>
                        <h2 class="page-header">Prompt</h2>
                    </div>
                    <div id="bb-prompt-examples" class="collapse in">
                        <div>
                            <p>
                                <b>Please note:</b> prompt requires the <code>title</code> option (when using the options object) and disallows the <code>message</code> option.
                            </p>
                            <ul class="bb-examples-list">
                                <li>
                                    <p class="bb-example">Basic usage</p>
                                    <p>
                                        <button type="button" class="btn btn-primary example-button" data-bb-example-key="prompt-default">Run example</button>
                                    </p>
                                    <pre class="prettyprint"><code>bootbox.prompt("This is the default prompt!", function(result){ console.log(result); });</code></pre>
                                </li>
                                <li>
                                    <p class="bb-example">Prompt with checkbox</p>
                                    <p>
                                        <button type="button" class="btn btn-primary example-button" data-bb-example-key="prompt-checkbox">Run example</button>
                                    </p>
                                    <pre class="prettyprint linenums"><code>bootbox.prompt({
    title: "This is a prompt with a set of checkbox inputs!",
    inputType: 'checkbox',
    inputOptions: [
        {
            text: 'Choice One',
            value: '1',
        },
        {
            text: 'Choice Two',
            value: '2',
        },
        {
            text: 'Choice Three',
            value: '3',
        }
    ],
    callback: function (result) {
        console.log(result);
    }
});</code></pre>
                                </li>
                                <li>
                                    <p class="bb-example">
                                        <span class="pull-right text-danger">
                                            Requires browser support: <a href="http://caniuse.com/#feat=input-datetime">http://caniuse.com/#feat=input-datetime</a>
                                        </span>
                                        Prompt with date
                                    </p>
                                    <p>
                                        <button type="button" class="btn btn-primary example-button" data-bb-example-key="prompt-date">Run example</button>
                                    </p>
                                    <pre class="prettyprint linenums"><code>bootbox.prompt({
    title: "This is a prompt with a date input!",
    inputType: 'date',
    callback: function (result) {
        console.log(result);
    }
});</code></pre>
                                </li>
                                <li>
                                    <p class="bb-example">
                                        <span class="pull-right text-danger">
                                            Requires browser support: <a href="http://caniuse.com/#feat=email">http://caniuse.com/#feat=email</a>
                                        </span>
                                        Prompt with email
                                    </p>
                                    <p>
                                        <button type="button" class="btn btn-primary example-button" data-bb-example-key="prompt-email">Run example</button>
                                    </p>
                                    <pre class="prettyprint linenums"><code>bootbox.prompt({
    title: "This is a prompt with an email input!",
    inputType: 'email',
    callback: function (result) {
        console.log(result);
    }
});</code></pre>
                                </li>
                                <li>
                                    <p class="bb-example">
                                        <span class="pull-right text-danger">
                                            Requires browser support: <a href="http://caniuse.com/#feat=input-number">http://caniuse.com/#feat=input-number</a>
                                        </span>
                                        Prompt with number
                                    </p>
                                    <p>
                                        <button type="button" class="btn btn-primary example-button" data-bb-example-key="prompt-number">Run example</button>
                                    </p>
                                    <pre class="prettyprint linenums"><code>bootbox.prompt({
    title: "This is a prompt with a number input!",
    inputType: 'number',
    callback: function (result) {
        console.log(result);
    }
});</code></pre>
                                </li>
                                <li>
                                    <p class="bb-example">Prompt with password</p>
                                    <p>
                                        <button type="button" class="btn btn-primary example-button" data-bb-example-key="prompt-password">Run example</button>
                                    </p>
                                    <pre class="prettyprint linenums"><code>bootbox.prompt({
    title: "This is a prompt with a password input!",
    inputType: 'password',
    callback: function (result) {
        console.log(result);
    }
});</code></pre>
                                </li>
                                <li>
                                    <p class="bb-example">Prompt with select</p>
                                    <p>
                                        <button type="button" class="btn btn-primary example-button" data-bb-example-key="prompt-select">Run example</button>
                                    </p>
                                    <pre class="prettyprint linenums"><code>bootbox.prompt({
    title: "This is a prompt with select!",
    inputType: 'select',
    inputOptions: [
        {
            text: 'Choose one...',
            value: '',
        },
        {
            text: 'Choice One',
            value: '1',
        },
        {
            text: 'Choice Two',
            value: '2',
        },
        {
            text: 'Choice Three',
            value: '3',
        }
    ],
    callback: function (result) {
        console.log(result);
    }
});</code></pre>
                                </li>
                                <li>
                                    <p class="bb-example">Prompt with textarea</p>
                                    <p>
                                        <button type="button" class="btn btn-primary example-button" data-bb-example-key="prompt-textarea">Run example</button>
                                    </p>
                                    <pre class="prettyprint linenums"><code>bootbox.prompt({
    title: "This is a prompt with a textarea!",
    inputType: 'textarea',
    callback: function (result) {
        console.log(result);
    }
});</code></pre>
                                </li>
                                <li>
                                    <p class="bb-example">
                                        <span class="pull-right text-danger">
                                            Requires browser support: <a href="http://caniuse.com/#feat=input-datetime">http://caniuse.com/#feat=input-datetime</a>
                                        </span>
                                        Prompt with time
                                    </p>
                                    <p>
                                        <button type="button" class="btn btn-primary example-button" data-bb-example-key="prompt-time">Run example</button>
                                    </p>
                                    <pre class="prettyprint linenums"><code>bootbox.prompt({
    title: "This is a prompt with a time input!",
    inputType: 'time',
    callback: function (result) {
        console.log(result);
    }
});</code></pre>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>


                <section id="bb-custom-dialog" class="bb-section">
                    <div class="bb-section-header">
                        <div class="pull-right">
                            <a href="./documentation.html#bb-custom-dialog" class="btn btn-link">Documentation</a>
                            |
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#bb-custom-examples" aria-expanded="false" aria-controls="bb-custom-examples">
                                Show / Hide
                            </button>
                        </div>
                        <h2 class="page-header">Custom Dialogs</h2>
                    </div>
                    <div id="bb-custom-examples" class="collapse in">
                        <div>
                            <p>
                                <b>Please note:</b> Custom dialogs accept only one argument: an options object. The only <b>required</b> property of the options object is <code>message</code>.
                            </p>
                            <ul class="bb-examples-list">
                                <li>
                                    <p class="bb-example">Custom dialog as "loading" overlay</p>
                                    <p>
                                        <button type="button" class="btn btn-primary example-button" data-bb-example-key="custom-dialog-as-overlay">Run example</button>
                                    </p>
                                    <pre class="prettyprint linenums"><code>var dialog = bootbox.dialog({
    message: '&lt;p class="text-center"&gt;Please wait while we do something...&lt;/p&gt;',
    closeButton: false
});
// do something in the background
dialog.modal('hide');</code></pre>
                                </li>
                                <li id="custom-dialog-init">
                                    <p class="bb-example">
                                        <span class="pull-right">
                                            Also applies to: <b>Alert</b>, <b>Confirm</b>, <b>Prompt</b>
                                        </span>
                                        Custom dialog, using init
                                    </p>
                                    <p>
                                        <button type="button" class="btn btn-primary example-button" data-bb-example-key="custom-dialog-init">Run example</button>
                                    </p>
                                    <pre class="prettyprint linenums"><code>var dialog = bootbox.dialog({
    title: 'A custom dialog with init',
    message: '&lt;p&gt;&lt;i class="fa fa-spin fa-spinner"&gt;&lt;/i&gt; Loading...&lt;/p&gt;'
});
dialog.init(function(){
    setTimeout(function(){
        dialog.find('.bootbox-body').html('I was loaded after the dialog was shown!');
    }, 3000);
});</code></pre>
                                </li>
                                <li id="custom-dialog-with-buttons">
                                    <p>Custom dialog, with buttons and button callbacks</p>
                                    <p>
                                        <button type="button" class="btn btn-primary example-button" data-bb-example-key="custom-dialog-with-buttons">Run example</button>
                                    </p>
                                    <pre class="prettyprint linenums"><code>var dialog = bootbox.dialog({
title: 'A custom dialog with buttons and callbacks',
message: "&lt;p&gt;This dialog has buttons. Each button has it's own callback function.&lt;/p&gt;",
buttons: {
    cancel: {
        label: "I'm a custom cancel button!",
        className: 'btn-danger',
        callback: function(){
            Example.show('Custom cancel clicked');
        }
    },
    noclose: {
        label: "I'm a custom button, but I don't close the modal!",
        className: 'btn-warning',
        callback: function(){
            Example.show('Custom button clicked');
            return false;
        }
    },
    ok: {
        label: "I'm a custom OK button!",
        className: 'btn-info',
        callback: function(){
            Example.show('Custom OK clicked');
        }
    }
}
});</code></pre>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <footer id="footer">
        <div class="container">
            <div class="pull-right">
                <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://bootboxjs.com" data-via="makeusabrew" data-related="makeusabrew" data-size="large">Tweet</a>
                <a href="https://twitter.com/makeusabrew" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @makeusabrew</a>
                <script>!function (d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if (!d.getElementById(id)) { js = d.createElement(s); js.id = id; js.src = "//platform.twitter.com/widgets.js"; fjs.parentNode.insertBefore(js, fjs); } }(document, "script", "twitter-wjs");</script>
            </div>
            &copy; 2011-2016 <a href="http://twitter.com/makeusabrew">Nick Payne</a>.
        </div>
    </footer>

    <div class="bb-alert alert alert-info" style="display:none;">
        <span>The examples populate this alert with dummy content</span>
    </div>

    <script src="model/jquery-1.12.3.min.js"></script>
    <script src="model/bootstrap.min.js"></script>
    <script src="model/anchor.js"></script>
    <script src="model/bootbox.js"></script>

    <script src="model/prettify.min.js"></script>
    <script src="model/jquery.scrollUp.min.js"></script>
    <script src="model/example.js"></script>
    <script src="model/demos.js"></script>
</body>
</html>
