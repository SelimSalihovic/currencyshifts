<!DOCTYPE html>
<html>
<head>
    <title>CurrencyShifts</title>
    <link href="{{'css/app.css'}}" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container text-center">

    <!-- start container -->
    <div class="row">
        <div class="title col-xs-8 col-xs-offset-2">
            <h1>CurrencyShifts</h1>
            <h3> <span class="json">JSON</span> API for exchange rates and currency conversion</h3>
            <p class="text-center">
                <img src="{{'img/currencyshifts.png'}}" width="150" alt=""/>
            </p>
            <br/>

            <div class="col-xs-offset-1 col-xs-10">
                <p class="description text-left">
                    CurrencyShifts is a <u>free</u> JSON API that provides exchange rates for all <strong>118</strong> world currencies.
                    The API is updated hourly and the data source is <a href="http://finance.yahoo.com">Yahoo Finance</a>.
                </p>
            </div>
        </div>
    </div>
    <div class="row" id="app">
        <div class="content col-xs-6 col-xs-offset-3 text-left">
            <div class="row">
                <h2 class="text-left">Usage</h2>
                <hr/>
            </div>
            <div class="row api-url">
                Retrieve the lastest exchange rates qouted by a base currency (By default the base is USD).
                <br/>
                <div class="api-url">
                    <p><strong class="get">GET</strong> <a href="{{url('api/v1/xrates')}}">{{url('api/v1/xrates')}}</a> <span class="text-muted show-response show-response" v-on="click: toggle1">See Response <span class="caret"></span></span></p>
                    <div class="response" v-show="active1">
                        <pre><code id=first_response></code></pre>
                    </div>
                    <p><strong class="get">GET</strong> <a href="{{url('api/v1/xrates?base=EUR')}}">{{url('api/v1/xrates?base=EUR')}}</a> <span class="text-muted show-response" v-on="click: toggle2">See Response <span class="caret"></span></span></p>
                    <div class="response" v-show="active2">
                        <pre><code id=second_response></code></pre>
                    </div>
                </div>
            </div>
            <br/>
            <div class="row api-url">
                Retrieve specific exchange rates set in the <strong>symbols</strong> parameter.
                <br/>
                <div class="api-url">
                    <p><strong class="get">GET</strong> <a href="{{url('api/v1/xrates?symbols=EUR,GBP')}}">{{url('api/v1/xrates?symbols=EUR,GBP')}}</a> <span class="text-muted show-response" v-on="click: toggle3">See Response <span class="caret"></span></span></p>
                    <div class="response" v-show="active3">
                        <pre><code id=third_response></code></pre>
                    </div>
                </div>
            </div>
            <br/>
            <div class="row api-url">
                Convert one currency to another by using <strong>base</strong> and <strong>to</strong> parameters.
                <br/>
                <div class="api-url">
                    <p><strong class="get">GET</strong> <a href="{{url('api/v1/xrates?base=GBP&to=EUR')}}">{{url('api/v1/xrates?base=GBP&to=EUR')}}</a> <span class="text-muted show-response" v-on="click: toggle4">See Response <span class="caret"></span></span></p>
                    <div class="response" v-show="active4">
                        <pre><code id=fourth_response></code></pre>
                    </div>
                </div>
            </div>
            <br/>
            <div class="row api-url">
                You can also pass the <strong>amount</strong> as a parameter.
                <br/>
                <div class="api-url">
                    <p><strong class="get">GET</strong> <a href="{{url('api/v1/xrates?base=GBP&to=EUR&amount=10')}}">{{url('api/v1/xrates?base=GBP&to=EUR&amount=10')}}</a> <span class="text-muted show-response" v-on="click: toggle5">See Response <span class="caret"></span></span></p>
                    <div class="response" v-show="active5">
                        <pre><code id=fifth_response></code></pre>
                    </div>
                    <p><strong class="get">GET</strong> <a href="{{url('api/v1/xrates?symbols=EUR,GBP,CHF&amount=10')}}">{{url('api/v1/xrates?symbols=EUR,GBP,CHF&amount=10')}}</a> <span class="text-muted show-response" v-on="click: toggle6">See Response <span class="caret"></span></span></p>
                    <div class="response" v-show="active6">
                        <pre><code id=sixth_response></code></pre>
                    </div>
                </div>
            </div>
            <br/>

            <div class="row api-url">
                You can also pass the <strong>base</strong> along with the symbols.
                <br/>
                <div class="api-url">
                    <p><strong class="get">GET</strong> <a href="{{url('api/v1/xrates?symbols=EUR,GBP,CHF&amount=10&base=BAM')}}">{{url('api/v1/xrates?symbols=EUR,GBP,CHF&amount=10&base=BAM')}}</a> <span class="text-muted show-response" v-on="click: toggle7">See Response <span class="caret"></span></span></p>
                    <div class="response" v-show="active7">
                        <pre><code id=seventh_response></code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div class="row text-left text-muted footer">
        <div class="col-xs-6 col-xs-offset-3">
            The API is hosted on GitHub <br/>
            We plan on going open-source soon <br/>
            The uptime is monitored by <a href="http://uptimerobot.com">UptimeRobot</a> <br/>
            We will work on, and update the API regularly
        </div>
    </div>
</div>


<!-- end container -->
<script>
    var first_response = <?php echo $provider->defaultCase();?>;
    var second_response = <?php echo $provider->specificBase();?>;
    var third_response = <?php echo $provider->symbols();?>;
    var fourth_response = <?php echo $provider->convert();?>;
    var fifth_response = <?php echo $provider->convertAmount();?>;
    var sixth_response = <?php echo $provider->symbolsAmount();?>;
    var seventh_response = <?php echo $provider->symbolsAmountBase();?>;
</script>
<script src="{{'js/all.js'}}"></script>

</body>
</html>