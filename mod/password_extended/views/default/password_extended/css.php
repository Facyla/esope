
#retype_password{
    display: none;
}
ul, li {
    margin:0;
    padding:0;
    list-style-type:none;
}

.invalid {

    padding-left:22px;
    line-height:24px;
    color:#ec3f41;
}

.valid {

    padding-left:22px;
    line-height:24px;
    color:#3a7d34;
}

#container {
    width:500px;
    padding:0px;
    background:#fefefe;
    margin: initial;
    border: none;
    bottom: 10px;
    position:relative;
}

#pswd_info {
    position:static;
    bottom:-65px;
    bottom: -115px\9; /* IE Specific */
    right:55px;
    width:500px;
    padding:2px;
    background:#fefefe;
    font-size:.875em;
    border-radius:5px;
    box-shadow:0 1px 3px #ccc;
    border:1px solid #ddd;
}

#pswd_info::before {
    content: "\25B2";
    position:absolute;
    top:-12px;
    left:45%;
    font-size:14px;
    line-height:14px;
    color:#ddd;
    text-shadow:none;
    display:block;
}

#pswd_info h4 {
    margin:0 0 10px 0;
    padding:0;
    font-weight:normal;
}

#ppbar{
    background:#CCC;
    width:300px;
    height:15px;
    margin:5px;
}
#pbar{
    margin:0px;
    width:0px;
    background:lightgreen;
    height: 100%;
}
#ppbartxt{
    text-align:right;
    margin:2px;
}

#pass-info{
    height: 25px;
    border: 1px none #DDD;
    border-radius: 4px;
    color: #829CBD;
    text-align: center;
    font: 12px/25px Arial, Helvetica, sans-serif;
}
#pass-info.weakpass{
    border: 1px solid #FF9191;
    background: #FFC7C7;
    color: #94546E;
    text-shadow: 1px 1px 1px #FFF;
}
#pass-info.stillweakpass {
    border: 1px solid #FBB;
    background: #FDD;
    color: #945870;
    text-shadow: 1px 1px 1px #FFF;
}
#pass-info.goodpass {
    border: 1px solid #C4EEC8;
    background: #E4FFE4;
    color: #51926E;
    text-shadow: 1px 1px 1px #FFF;
}
#pass-info.strongpass {
    border: 1px solid #6ED66E;
    background: #79F079;
    color: #348F34;
    text-shadow: 1px 1px 1px #FFF;
}
#pass-info.vrystrongpass {
    border: 1px solid #379137;
    background: #48B448;
    color: #CDFFCD;
    text-shadow: 1px 1px 1px #296429;
}