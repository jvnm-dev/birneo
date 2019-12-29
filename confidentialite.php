
<!DOCTYPE html>
<html lang="fr">
   <head>
      <meta charset="utf-8">
      <title>Politique de confidentialité</title>
      <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="">

      <!-- Le styles -->
      <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
      <link href="../assets/css/bootBirneo.css" rel="stylesheet">
      <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
      <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
      }

      /* Custom container */
      .container-narrow {
        margin: 0 auto;
        max-width: 700px;
      }
      .container-narrow > hr {
        margin: 30px 0;
      }

      /* Main marketing message and sign up button */
      .jumbotron {
        margin: 60px 0;
        text-align: center;
      }
      .jumbotron h1 {
        font-size: 60px;
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

      .birneo_unselectable
      {
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: moz-none;
        -ms-user-select: none;
        user-select: none;
      }

      <?php
        require("res/color.css");
      ?>
      </style>
      <link href="../assets/css/bootplus-responsive.css" rel="stylesheet">

      <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
      <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
      <![endif]-->

      <!-- Fav and touch icons -->
      <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="../assets/ico/favicon.png">
  </head>

  <body>

      <div class="container-narrow well">
        <div class="page-header">
          <h2 style="font-weight:normal;">Birneo</h2> 
          <?php
            if(isset($_SESSION['userid']))
            {
              echo '<a href="http://'.$_SERVER['SERVER_ADDR'].'/home">Retour à l\'accueil</a> - ';
            }
            echo ' <a href="http://'.$_SERVER['SERVER_ADDR'].'/conditions">Conditions d\'utilisation</a>';
          ?>
        </div>
      <div class="row">
        <div class="span7">
          <h1>Politique mod&egrave;le de confidentialit&eacute;.</h1>
          <p><strong>Introduction</strong><br />
          Devant le d&eacute;veloppement des nouveaux outils de communication, il est n&eacute;cessaire de porter une attention particuli&egrave;re &agrave; la protection de la vie priv&eacute;e. 
          C'est pourquoi, nous nous engageons &agrave; respecter la confidentialit&eacute; des renseignements personnels que nous collectons.
          </p><hr/>
          <h2>Collecte des renseignements personnels</h2>
          <p>
          Nous collectons les renseignements suivants : 
          </p>
          <ul>
                <li>Nom</li>
                <li>Pr&eacute;nom</li>
                <li>Adresse &eacute;lectronique</li>
                <li>Genre / Sexe</li>
                <li>&Acirc;ge / Date de naissance</li>
                <li>Scolarit&eacute; / Formation</li>
                <li>Profession</li>
                <li>Pr&eacute;f&eacute;rences (musicales, litt&eacute;raires, cin&eacute;matographiques, etc.)</li>
                <li>Description physique</li>
                <li>Situation familiale</li>
            </ul>

          <p>
            Les renseignements personnels que nous collectons sont recueillis au travers de formulaires et gr&acirc;ce &agrave; 
            l'interactivit&eacute; &eacute;tablie entre vous et notre site Web.
            Nous utilisons &eacute;galement, comme indiqu&eacute; dans la section suivante, des fichiers t&eacute;moins et/ou journaux 
            pour r&eacute;unir des informations vous concernant.
          </p><hr/>
          <h2>Formulaires&nbsp; et interactivit&eacute;:</h2>
          <p>
            Vos renseignements personnels sont collect&eacute;s par le biais de formulaire, &agrave; savoir :
          </p>
            <ul>
                    <li>Formulaire d'inscription au site Web</li>
                </ul>
          <p>
            Nous utilisons les renseignements ainsi collect&eacute;s pour les finalit&eacute;s suivantes :
          </p>
          <ul>
                <li>Contact</li>
                <li>Gestion du site Web (pr&eacute;sentation, organisation)
          </li>
            </ul>
          <p>
            Vos renseignements sont &eacute;galement collect&eacute;s par le biais de l'interactivit&eacute; pouvant s'&eacute;tablir entre vous et notre site Web et ce, de la fa&ccedil;on suivante:
          </p>  
          <ul>
                <li>Contact</li>
                <li>Gestion du site Web (pr&eacute;sentation, organisation)</li>
            </ul>
          <p>
            Nous utilisons les renseignements ainsi collect&eacute;s pour les finalit&eacute;s suivantes :<br />
          </p>
            <ul>
                    <li>Forum ou aire de discussion</li>
                    <li>Commentaires
          </li>
                    <li>Correspondance</li>
                </ul>
          <hr/>
          <h2>Fichiers journaux et t&eacute;moins </h2>
          <p>
          Nous recueillons certaines informations par le biais de fichiers journaux (log file) et de fichiers t&eacute;moins (cookies). Il s'agit principalement des informations suivantes :
          </p>
          <ul>
                      <li>Adresse IP</li>
                </ul>

          <br />
          <p>
          Le recours &agrave; de tels fichiers nous permet : 
          </p>
          <ul >
                <li>De prévenir une attaque (DDOS par exemple)</li>
            </ul><hr/>
          <h2>Partage des renseignements personnels</h2>

          <p>
          Nous nous engageons &agrave; ne pas commercialiser les renseignements personnels collect&eacute;s. Toutefois, il nous arrive de partager ces informations avec des tiers pour les raisons suivantes : 
          </p>
          <ul>
                <li>Profil de consommation
          </li>
            </ul>
          <p>
            Si vous ne souhaitez pas que vos renseignements personnels soient communiqu&eacute;s &agrave; des tiers, il vous est possible de vous 
            y opposer au moment de la collecte ou &agrave; tout moment par la suite, comme mentionn&eacute; dans la section suivante.
          </p><hr/>
          <h2>Droit d'opposition et de retrait</h2>
          <p>
            Nous nous engageons &agrave; vous offrir un droit d'opposition et de retrait quant &agrave; vos renseignements personnels.<br />
            Le droit d'opposition s'entend comme &eacute;tant la possiblit&eacute; offerte aux internautes de refuser que leurs renseignements 
            personnels soient utilis&eacute;es &agrave; certaines fins mentionn&eacute;es lors de la collecte.<br />
          </p>
          <p>
            Le droit de retrait s'entend comme &eacute;tant la possiblit&eacute; offerte aux internautes de demander &agrave; ce que leurs 
            renseignements personnels ne figurent plus, par exemple, dans une liste de diffusion.<br />
          </p>
          <p>
            Pour pouvoir exercer ces droits, vous pouvez : <br />
            Courriel : jasonvanmalder@gmail.com<br />   Section du site web : http://birneo.com/support<br />  </p><hr/>
          <h2>Droit d'acc&egrave;s</h2>
          <p>
            Nous nous engageons &agrave; reconna&icirc;tre un droit d'acc&egrave;s et de rectification aux personnes 
            concern&eacute;es d&eacute;sireuses de consulter, modifier, voire radier les informations les concernant.<br />

            
            L'exercice de ce droit se fera :<br />
            Courriel : jasonvanmalder@gmail.com<br />   
            Section du site web : http://birneo.com/<br />  </p><hr/>
          <h2>S&eacute;curit&eacute;</h2>
          <p>

            Les renseignements personnels que nous collectons sont conserv&eacute;s 
            dans un environnement s&eacute;curis&eacute;. Les personnes travaillant pour nous sont tenues de respecter la confidentialit&eacute; de vos informations.<br />
            Pour assurer la s&eacute;curit&eacute; de vos renseignements personnels, nous avons recours aux mesures suivantes :
          </p>
            <ul>
                            <li>Gestion des acc&egrave;s - personne autoris&eacute;e</li>
                                  <li>Gestion des acc&egrave;s - personne concern&eacute;e</li>
                                  <li>Identifiant / mot de passe</li>
                      </ul>

          <p>
            Nous nous engageons &agrave; maintenir un haut degr&eacute; de confidentialit&eacute; en int&eacute;grant les derni&egrave;res innovations technologiques permettant d'assurer 
            la confidentialit&eacute; de vos transactions. Toutefois, comme aucun m&eacute;canisme n'offre une s&eacute;curit&eacute; maximale, une part de risque est toujours pr&eacute;sente 
            lorsque l'on utilise Internet pour transmettre des renseignements personnels. 
          </p><hr/>
          <h2>Enfants</h2>
          <p>
            Notre site Web contient des sections destin&eacute;es aux enfants. 
            La collecte de leurs renseignements personnels se fait avec 
            le consentement des parents ou du repr&eacute;sentant de l'enfant.
                Nous demandons le consentement de ces derniers par le biais :
            </p>
            <ul>
                    <li>Formulaire d'inscription  
          </li>
                </ul><hr/>
          <h2>L&eacute;gislation</h2>
          <p>
            Nous nous engageons &agrave; respecter les dispositions l&eacute;gislatives &eacute;nonc&eacute;es dans :
            <br />législation belge
          </p>
        </div>
      </div>
      </div> <!-- /container -->
   </body>
</html>
