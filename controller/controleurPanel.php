<?php
require('lib/fpdf/fpdf.php');
require_once __DIR__ . '/../modeles/DAO/UtilisateurDAO.php';
require_once __DIR__ . '/../modeles/DAO/ArticleDAO.php';
require_once __DIR__ . '/../modeles/DAO/CommandeDAO.php';
require_once __DIR__ . '/../modeles/DAO/CommentaireDAO.php';
require_once __DIR__ . '/../modeles/DAO/LigneCommandeDAO.php';
require_once __DIR__ . '/../modeles/DAO/ProduitDAO.php';
require_once __DIR__ . '/../lib/Formulaire.php';
require_once __DIR__ . '/../lib/Menu.php';



if(isset($_GET['menuPanel'])){
	$_SESSION['menuPanel']= $_GET['menuPanel'];
}
else
{
	if(!isset($_SESSION['menuPanel'])){
		$_SESSION['menuPanel']="panel";
	}
}
if (isset($_POST['Valider']) && !empty($_POST['login'] && !empty($_POST['motdepasse']))){
	$result = UtilisateurDAO::verification($_POST['login'], $_POST['motdepasse']);
	$auth = $result['Statut'];
	$_SESSION['statut'] = $result['Statut']; 
	if($auth == null){
		$messageErreurConnexion = "Login ou mot de passe incorrect";
        $_SESSION['authentification'] = false;
	}
	elseif($auth === "admin"){
        $_SESSION['authentification'] = $result;
	}
	elseif($auth === "GestionCommande"){
        $_SESSION['authentification'] = $result;
	}
}
if($_SESSION['authentification']['Statut'] == "admin"){
	$menuPanel = new Menu("menuPanel");

	$menuPanel->ajouterComposant($menuPanel->creerItemLien("Produits", "panelProduit", "fas fa-box"));
	$menuPanel->ajouterComposant($menuPanel->creerItemLien("Commandes", "panelCommande", "fas fa-shopping-cart"));
	$menuPanel->ajouterComposant($menuPanel->creerItemLien("Commentaires", "panelCommentaire", "far fa-comment-alt"));
	$menuPanel->ajouterComposant($menuPanel->creerItemLien("Articles", "panelArticle", "far fa-comment-alt"));
	$menuPanel->ajouterComposant($menuPanel->creerItemLien("Deconnexion", "panelDeco", "fas fa-sign-out-alt"));
	
	$menuPanel = $menuPanel->creerMenu("menuPanel",$_SESSION['menuPanel']);




/*---------------------------------------------------------Panel   Produit---------------------------------------------------*/
$listeProduit = ProduitDAO::getAll();
$menuProduit = new Menu("menuProduitPanel");
$formCreerProduit = new Formulaire("post","index.php?menuPanel=panelProduit","menuProduitPanel","menuProduitPanel");
foreach($listeProduit as $unProduit){
	$menuProduit->ajouterComposant($menuProduit->creerItemLien($unProduit['Nom'],$unProduit['ID']));
}
$formCreerProduit->ajouterComposantLigne($formCreerProduit->creerInputSubmit("CreerProduit", "CreerProduit","Ajouter un Produit"),1);
$formCreerProduit->ajouterComposantTab();
$menuProduit = $menuProduit->creerMenu("produit" ,$listeProduit,"index.php?menuPanel=panelProduit");
$formCreerProduit->creerFormulaire();


$formInfoProduit = new Formulaire("post","#","formProduitPanel", "formProduitPanel", "multipart/form-data");
$formAjoutProduit = new Formulaire("post","#","formProduitPanel", "formProduitPanel", "multipart/form-data");

if(isset($_GET['produit'])){
	$idProduit = $_GET['produit'];
    $infoProduit = ProduitDAO::getById($idProduit);
	$descriptionCourte = substr($infoProduit[0]['Description'], 0, 64);

	if(isset($_POST['modifierProduit'])){   
	
		$formInfoProduit->ajouterComposantLigne($formInfoProduit->creerImg($infoProduit[0]['Photo'], "imgProduit"),1);
		$formInfoProduit->ajouterComposantLigne($formInfoProduit->creerInputFile("Image","Image",".png,.jpeg,.jpg"),1);
		$formInfoProduit->ajouterComposantTab();
		$formInfoProduit->ajouterComposantLigne($formInfoProduit->creerLabel("Nom : ", "nomProduit"),1);
		$formInfoProduit->ajouterComposantLigne($formInfoProduit->creerInputTexte("inputNom","inputNom",$infoProduit[0]['Nom'],1,"",0),1);
		$formInfoProduit->ajouterComposantTab();
		$formInfoProduit->ajouterComposantLigne($formInfoProduit->creerLabel("Prix :", "prixProduit"),1);
		$formInfoProduit->ajouterComposantLigne($formInfoProduit->creerInputTexte("inputPrix","inputPrix",$infoProduit[0]['Prix'] ." €",1,"",0),1);
		$formInfoProduit->ajouterComposantTab();
		$formInfoProduit->ajouterComposantLigne($formInfoProduit->creerLabel("Description :", "descriptionProduit"),1);
		$formInfoProduit->ajouterComposantLigne($formInfoProduit->creerTextArea("inputDescription", "inputDescription", $descriptionCourte, 5 , 10, 1,0),1);
		$formInfoProduit->ajouterComposantTab();
		$formInfoProduit->ajouterComposantLigne($formInfoProduit->creerInputSubmit("validerProduit","validerProduit","Valider"),1);
		$formInfoProduit->ajouterComposantLigne($formInfoProduit->creerInputSubmit("annulerProduit","annulerProduit","Annuler"),1);
		$formInfoProduit->ajouterComposantTab();
		$formInfoProduit->creerFormulaire();
	}
	else{
		$formInfoProduit->ajouterComposantLigne($formInfoProduit->creerImg($infoProduit[0]['Photo'], "imgProduit"),1);
		$formInfoProduit->ajouterComposantTab();
		$formInfoProduit->ajouterComposantLigne($formInfoProduit->creerLabel("Nom : ", "nomProduit"),1);
		$formInfoProduit->ajouterComposantLigne($formInfoProduit->creerInputTexte("inputNom","inputNom",$infoProduit[0]['Nom'],1,"",1),1);
		$formInfoProduit->ajouterComposantTab();
		$formInfoProduit->ajouterComposantLigne($formInfoProduit->creerLabel("Prix :", "prixProduit"),1);
		$formInfoProduit->ajouterComposantLigne($formInfoProduit->creerInputTexte("inputPrix","inputPrix",$infoProduit[0]['Prix'] ." €",1,"",1),1);
		$formInfoProduit->ajouterComposantTab();
		$formInfoProduit->ajouterComposantLigne($formInfoProduit->creerLabel("Description :", "descriptionProduit"),1);
		$formInfoProduit->ajouterComposantLigne($formInfoProduit->creerTextArea("inputDescription", "inputDescription", $descriptionCourte, 5 , 10, 1,1),1);
		$formInfoProduit->ajouterComposantTab();
		$formInfoProduit->ajouterComposantLigne($formInfoProduit->creerInputSubmit("modifierProduit","modifierParoduit","Modifier"),1);
		$formInfoProduit->ajouterComposantLigne($formInfoProduit->creerInputSubmit("supprimerProduit","supprimerProduit","Supprimer"),1);
		$formInfoProduit->ajouterComposantTab();
		$formInfoProduit->creerFormulaire();
	}
	
}
if (isset($_POST['validerProduit'])) {
    $nom = urldecode($_POST['inputNom']);
    $prix = urldecode($_POST['inputPrix']);
    $description = urldecode($_POST['inputDescription']);
    $prix = html_entity_decode($prix);
	$prix = str_replace('€', '', $prix);

    $dossier = "images/bouteilles";
    $fichierDestination = null;

    if (isset($_FILES["Image"]["name"]) && $_FILES["Image"]["name"] != "") {
        $imageName = basename($_FILES["Image"]["name"]);
        $fichierDestination = $dossier . '/' . $imageName;

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            echo "Extension de fichier non autorisée.";
        } else {
            if (move_uploaded_file($_FILES["Image"]["tmp_name"], $fichierDestination)) {
                echo "Image téléchargée avec succès!";
            } else {
                echo "Erreur lors du téléchargement de l'image.";
            }
        }
    } else {
        echo "Aucun fichier téléchargé.";
		$fichierDestination = $infoProduit[0]['Photo'];
    }

    ProduitDAO::update($idProduit, $nom, $prix, $description, $fichierDestination);
}
if(isset($_POST['CreerProduit'])){
	$formAjoutProduit->ajouterComposantLigne($formAjoutProduit->creerInputFile("Image","Image",".png,.jpeg,.jpg"),1);
	$formAjoutProduit->ajouterComposantTab();
	$formAjoutProduit->ajouterComposantLigne($formAjoutProduit->creerLabel("Nom : ", "nomProduit"),1);
	$formAjoutProduit->ajouterComposantLigne($formAjoutProduit->creerInputTexte("inputNom","inputNom","",1,"",0),1);
	$formAjoutProduit->ajouterComposantTab();
	$formAjoutProduit->ajouterComposantLigne($formAjoutProduit->creerLabel("Prix :", "prixProduit"),1);
	$formAjoutProduit->ajouterComposantLigne($formAjoutProduit->creerInputTexte("inputPrix","inputPrix","" ." €",1,"",0),1);
	$formAjoutProduit->ajouterComposantTab();
	$formAjoutProduit->ajouterComposantLigne($formAjoutProduit->creerLabel("Description :", "descriptionProduit"),1);
	$formAjoutProduit->ajouterComposantLigne($formAjoutProduit->creerTextArea("inputDescription", "inputDescription", "", 5 , 10, 1,0),1);
	$formAjoutProduit->ajouterComposantTab();
	$formAjoutProduit->ajouterComposantLigne($formAjoutProduit->creerInputSubmit("ajouterProduit","ajouterProduit","Ajouter"),1);
	$formAjoutProduit->ajouterComposantLigne($formAjoutProduit->creerInputSubmit("annulerProduit","annulerProduit","Annuler"),1);
	$formAjoutProduit->ajouterComposantTab();
	$formAjoutProduit->creerFormulaire();
}
if(isset($_POST['ajouterProduit'])){
	$nom = urldecode($_POST['inputNom']);
    $prix = urldecode($_POST['inputPrix']);
    $description = urldecode($_POST['inputDescription']);
    $prix = html_entity_decode($prix);
	$prix = str_replace('€', '', $prix);

    $dossier = __DIR__ . '/../images/bouteilles';

    if (isset($_FILES["Image"]["name"])) {
        $imageName = basename($_FILES["Image"]["name"]);
        $fichierDestination = $dossier . '/' . $imageName;

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            echo "Extension de fichier non autorisée.";
        } else {
            if (move_uploaded_file($_FILES["Image"]["tmp_name"], $fichierDestination)) {
                echo "Image téléchargée avec succès!";
				ProduitDAO::create($nom,$prix,$description,$fichierDestination);
				header("Location: index.php?menuPanel=panelProduit");
				exit();
            } else {
                echo "Erreur lors du téléchargement de l'image.";
            }
        }
    } else {
        echo "Aucun fichier téléchargé.";
    }
}
if(isset($_POST['supprimerProduit'])){
	ProduitDAO::delete($idProduit);
	header("Location: index.php?menuPanel=panelProduit");
	exit();
}

/*--------------------------------------------------------Panel Commentaire-------------------------------------------------------*/



$statut = ['--','En Attente','Validé','Refusé'];
$nomProduits = ProduitDAO::getAllNomBoth();
$nomProduit = ['--'];
foreach($nomProduits as $produit){
	array_push($nomProduit,$produit['Nom']);
}
if(isset($_POST['validerFiltre'])){
	$n = $_POST['selectNom'];
	$s = $_POST['selectStatut'];
}
else{
	$n =null;
	$s = null;
}
$formSelect = new Formulaire("post","index.php?menuPanel=panelCommentaire","formSelect","formSelect");
$formSelect->ajouterComposantLigne($formSelect->creerSelect("selectStatut", "selectStatut","selectStatut",$statut,null, $s),1);
$formSelect->ajouterComposantLigne($formSelect->creerSelect("selectNom", "selectNom", "selectNom", $nomProduit, null, $n), 1);
$formSelect->ajouterComposantTab();
$formSelect->ajouterComposantLigne($formSelect->creerInputSubmit("validerFiltre","validerFiltre" , "Filtrer"),1);
$formSelect->ajouterComposantTab();
$formSelect->creerFormulaire();

if(isset($_POST['validerFiltre'])){
	$_SESSION['selectedProduct'] = isset($_POST['selectNom']) ? $_POST['selectNom'] : '--';
	if($_POST['selectStatut'] == "--" && $_POST['selectNom'] == "--"){
		$listeCommentaire = CommentaireDAO::getAll();
	}
	else if($_POST['selectStatut'] != "--" && $_POST['selectNom'] !="--"){
		$statutFiltre = $_POST['selectStatut'];
		$nomFiltre = $_POST['selectNom'];
		$listeCommentaire = CommentaireDAO::getByProductNameAStatut($nomFiltre,$statutFiltre);
	}
	else if($_POST['selectStatut'] == "--" && $_POST['selectNom'] !="--"){
		$nomFiltre = $_POST['selectNom'];
		$listeCommentaire = CommentaireDAO::getByProductName($nomFiltre);
	}
	elseif($_POST['selectStatut'] != "--" && $_POST['selectNom'] =="--"){
		$statutFiltre = $_POST['selectStatut'];
		$listeCommentaire = CommentaireDAO::getByStatut($statutFiltre);
	}


	$menuCom = new Menu("menuCommentaire");
	foreach($listeCommentaire as $unComm){
		$menuCom->ajouterComposant($menuCom->creerItemLien($unComm['NomPrenom'],$unComm['id']));
	}

	$menuCom = $menuCom->creerMenu("commentaire" ,$listeCommentaire,"index.php?menuPanel=panelCommentaire");
}
if(isset($_GET['commentaire'])){
	
	$formCommentaire = new Formulaire("post","#","formCommentaire","formCommentaire");
	$idComm = $_GET['commentaire'];
	$commentaire = CommentaireDAO::getById($idComm);
	$formCommentaire->ajouterComposantLigne($formCommentaire->creerLabel("Date : ".$commentaire[0]['date'],"dateComm"),1);
	$formCommentaire->ajouterComposantTab();
	$formCommentaire->ajouterComposantLigne($formCommentaire->creerLabel("Nom Prénom : ".$commentaire[0]['NomPrenom'],"nomPrenomCom"),1);
	$formCommentaire->ajouterComposantTab();
	$formCommentaire->ajouterComposantLigne($formCommentaire->creerLabel("Produit : ".$commentaire[0]['Nom'],"nomProduitCom"),1);
	$formCommentaire->ajouterComposantTab();
	$formCommentaire->ajouterComposantLigne($formCommentaire->creerLabel("Libelle : ".$commentaire[0]['Libelle'],"libelleCom"),1);
	$formCommentaire->ajouterComposantTab();
	$formCommentaire->ajouterComposantLigne($formCommentaire->creerSelect("selectStatutCom", "selectStatutCom","selectStatutCom",$statut,"this.form.submit()"),1);
	$formCommentaire->ajouterComposantTab();
	$formCommentaire->creerFormulaire();
}

if(isset($_POST['selectStatutCom'])){
	if($_POST['selectStatutCom'] != "--"){
		$statut = $_POST['selectStatutCom'];
		echo $statut;
		$idComm = $_GET['commentaire'];
		CommentaireDAO::updateStatut($idComm,$statut);
	}
}


/*------------------------------------------------------Panel Article-------------------------------------------------------------*/

$menuArticle = new Menu("menuArticle");
$articles = ArticleDAO::getAll();
foreach($articles as $article){
	$menuArticle->ajouterComposant($menuArticle->creerItemLien($article['titre'],$article['id']));
}
$formCreerArticle = new Formulaire("post","#","formCreerArticle","formCreerArticle");
$formCreerArticle->ajouterComposantLigne($formCreerArticle->creerInputSubmit("creerArticle","creerArticle","Ajouter un article"),1);
$formCreerArticle->ajouterComposantTab();
$formCreerArticle->creerFormulaire();
$menuArticle=$menuArticle->creerMenu("Article",$articles,"index.php?menuPanel=panelArticle");
$formArticle = new Formulaire("post" , "#" ,"formArticle","formArticle");
if(isset($_GET['Article'])){
	$idArticle = $_GET['Article'];

	$infoArticle = ArticleDAO::getById($idArticle);

	if(isset($_POST['modifierArticle'])){   

		$formArticle->ajouterComposantLigne($formArticle->creerLabel("Titre : ", "titreArticle"),1);
		$formArticle->ajouterComposantLigne($formArticle->creerInputTexte("inputTitre","inputTitre",$infoArticle[0]['titre'],1,"",0),1);
		$formArticle->ajouterComposantTab();
		$formArticle->ajouterComposantLigne($formArticle->creerLabel("Contenu :", "descriptionProduit"),1);
		$formArticle->ajouterComposantLigne($formArticle->creerTextArea("inputDescription", "inputDescription", $infoArticle[0]['Description'], 5 , 10, 1,0),1);
		$formArticle->ajouterComposantTab();
		$formArticle->ajouterComposantLigne($formArticle->creerInputSubmit("validerArticle","validerArticle","Valider"),1);
		$formArticle->ajouterComposantLigne($formArticle->creerInputSubmit("annulerArticle","annulerArticle","Annuler"),1);
		$formArticle->ajouterComposantTab();
		$formArticle->creerFormulaire();
	}
	else{
		$formArticle->ajouterComposantLigne($formArticle->creerLabel("Titre : ", "titreArticle"),1);
		$formArticle->ajouterComposantLigne($formArticle->creerInputTexte("inputTitre","inputTitre",$infoArticle[0]['titre'],1,"",1),1);
		$formArticle->ajouterComposantTab();
		$formArticle->ajouterComposantLigne($formArticle->creerLabel("Contenu :", "descriptionProduit"),1);
		$formArticle->ajouterComposantLigne($formArticle->creerTextArea("inputDescription", "inputDescription", $infoArticle[0]['Description'], 5 , 10, 1,1),1);
		$formArticle->ajouterComposantTab();
		$formArticle->ajouterComposantLigne($formArticle->creerInputSubmit("modifierArticle","modifierArticle","Modifier"),1);
		$formArticle->ajouterComposantLigne($formArticle->creerInputSubmit("supprimerArticle","supprimerArticle","Supprimer"),1);
		$formArticle->ajouterComposantTab();
		$formArticle->creerFormulaire();
	}
}
if(isset($_POST['supprimerArticle'])){
	$id = $_GET['Article'];
	ArticleDAO::delete($id);
	header('Location: index.php?menuPanel=panelArticle');
	exit();
}

if(isset($_POST['creerArticle'])){
	$formArticle->ajouterComposantLigne($formArticle->creerLabel("Titre : ", "titreArticle"),1);
	$formArticle->ajouterComposantLigne($formArticle->creerInputTexte("inputTitre","inputTitre","",1,"",0),1);
	$formArticle->ajouterComposantTab();
	$formArticle->ajouterComposantLigne($formArticle->creerLabel("Description :", "descriptionArticle"),1);
	$formArticle->ajouterComposantLigne($formArticle->creerTextArea("inputDescription", "inputDescription", "", 5 , 10, 1,0),1);
	$formArticle->ajouterComposantTab();
	$formArticle->ajouterComposantLigne($formArticle->creerInputSubmit("ajouterArticle","ajouterArticle","Ajouter"),1);
	$formArticle->ajouterComposantLigne($formArticle->creerInputSubmit("annulerArticle","annulerArticle","Annuler"),1);
	$formArticle->ajouterComposantTab();
	$formArticle->creerFormulaire();
}
if(isset($_POST['ajouterArticle'])){
	$titre = $_POST['inputTitre'];
	$description = $_POST['inputDescription'];
	ArticleDAO::create($description,$titre);
}	
if(isset($_POST['validerArticle'])){
	$id = $_GET['Article'];
	$titre =$_POST['inputTitre'];
	$description = $_POST['inputDescription'];

	ArticleDAO::update($id,$description,$titre);
}

/*-------------------------------------------------------------Panel Commande--------------------------------------------------------------------*/

$option = ["Toute","En attente","Prête","Receptionné"];

if(isset($_POST['validerFiltreCommande'])){
	$default = $_POST['selectStatutCommande'];
}
else{
	$default = null;
}

$formSelectCommande = new Formulaire("post","#","formSelectCommande","formSelectCommande");
$formSelectCommande->ajouterComposantLigne($formSelectCommande->creerSelect("selectStatutCommande", "selectStatutCommande","selectStatutCommande",$option,null, $default),1);
$formSelectCommande->ajouterComposantTab();
$formSelectCommande->ajouterComposantLigne($formSelectCommande->creerInputSubmit("validerFiltreCommande","validerFiltreCommande" , "Filtrer"),1);
$formSelectCommande->ajouterComposantTab();
$formSelectCommande->creerFormulaire();


if(isset($_POST['validerFiltreCommande'])){
	if($_POST['selectStatutCommande'] === "Toute"){
		$commandes = CommandeDAO::getAll();
	}
	else{
		$statut = $_POST['selectStatutCommande'];
		$commandes = CommandeDAO::getByStatut($statut);
	}
}
else{
	$commandes = CommandeDAO::getAll();
}


$menuCommandes = new Menu("menuCommandes");

foreach ($commandes as $commande) {

	$menuCommandes->ajouterComposant($menuCommandes->creerItemLien("Commande n° " .$commande['Num'] /*. "  Date :".$commande['DateReception']*/,$commande['Num']));

}

$menuCommandes = $menuCommandes->creerMenu("commande",$commandes,"index.php?menuPanel=panelCommande");

if(isset($_GET['commande'])){
	$numCommande = $_GET['commande'];
	$commande = CommandeDAO::getByNum($numCommande);
	$lignesCommande = LigneCommandeDAO::getByNumCommande($numCommande);
	$formInfoCommande = new Formulaire("post" , "#" ,"formInfoCommande","formInfoCommande");
	$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel("Nom Prénom :","lblNPClient"),1);
	$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel($commande[0]['NomClient']."  " .$commande[0]['PrenomClient'],"lblNPCleint"),1);
	$formInfoCommande->ajouterComposantTab();
	$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel("Mail :","lblNPClient"),1);
	$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel($commande[0]['MailClient'],"lblNPCleint"),1);
	$formInfoCommande->ajouterComposantTab();
	$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel("Téléphone :","lblNPClient"),1);
	$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel($commande[0]['TelephoneClient'],"lblNPCleint"),1);
	$formInfoCommande->ajouterComposantTab();
	$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel("Lieu Réception :","lblNPClient"),1);
	$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel($commande[0]['LieuReception'],"lblNPCleint"),1);
	$formInfoCommande->ajouterComposantTab();
	$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel("Date Réception :","lblNPClient"),1);
	$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel($commande[0]['DateReception'],"lblNPCleint"),1);
	$formInfoCommande->ajouterComposantTab();
	$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel("Prix Total :","lblNPClient"),1);
	$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel($commande[0]['prix']. "  €","lblNPCleint"),1);
	$formInfoCommande->ajouterComposantTab();
	$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel("Produits :","lblNPClient"),1);
	$formInfoCommande->ajouterComposantTab();
	$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel("Nom" , "r"),1);
	$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel("Quantité" , "r"),1);
	$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel("Prix" , "r"),1);
	$formInfoCommande->ajouterComposantTab();
	foreach($lignesCommande as $uneligne){
		$infoProduit = LigneCommandeDAO::getInfoByIdProduit($uneligne['ID'],$uneligne['Num']);
		$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel($infoProduit[0]['Nom'] , "r"),1);
		$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel($infoProduit[0]['Quantite'] , "r"),1);
		$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel($infoProduit[0]['Prix'] * $infoProduit[0]['Quantite']  . " €" , "r"),1);
		$formInfoCommande->ajouterComposantTab();
	}
	$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerInputSubmit("pdf","pdf","Télécharger en PDF"),1);
	if($commande[0]['Statut'] == "En attente"){
		$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerInputSubmit("prete","prete","Commande prête"),1);
	}
	else if($commande[0]['Statut'] == "Prête"){
		$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel("Commande Prête","cmdP"),1);
		$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerInputSubmit("receptionne","receptionne","Commande receptionné"),1);
	}
	$formInfoCommande->ajouterComposantTab();
	$formInfoCommande->creerFormulaire();
}

if(isset($_POST['pdf'])){
	$data = $_GET['commande'];
	header('Location: pdf/commandePDF?nCom='.urlencode($data));
	exit();
}
if(isset($_POST['prete'])){
	$num = $_GET['commande'];
	CommandeDAO::updateStatut($num,"Prête");
	$url = $_SERVER['REQUEST_URI'];
	header('Location: ' . $url);
	exit();
}
if(isset($_POST['receptionne'])){
	$num = $_GET['commande'];
	CommandeDAO::updateStatut($num,"Réceptionné");
	$url = $_SERVER['REQUEST_URI'];
	header('Location: ' . $url);
	exit();
}



}
if($_SESSION['authentification']['Statut'] == "GestionCommande"){
	$menuPanel = new Menu("menuPanel");

	$menuPanel->ajouterComposant($menuPanel->creerItemLien("Commandes", "panelCommande", "fas fa-shopping-cart"));
	$menuPanel->ajouterComposant($menuPanel->creerItemLien("Deconnexion", "panelDeco", "fas fa-sign-out-alt"));
	
	$menuPanel = $menuPanel->creerMenu("menuPanel",$_SESSION['menuPanel']);

	/*-------------------------------------------------------------Panel Commande--------------------------------------------------------------------*/

	$option = ["Toute","En attente","Prête","Receptionné"];

	if(isset($_POST['validerFiltreCommande'])){
		$default = $_POST['selectStatutCommande'];
	}
	else{
		$default = null;
	}

	$formSelectCommande = new Formulaire("post","#","formSelectCommande","formSelectCommande");
	$formSelectCommande->ajouterComposantLigne($formSelectCommande->creerSelect("selectStatutCommande", "selectStatutCommande","selectStatutCommande",$option,null, $default),1);
	$formSelectCommande->ajouterComposantTab();
	$formSelectCommande->ajouterComposantLigne($formSelectCommande->creerInputSubmit("validerFiltreCommande","validerFiltreCommande" , "Filtrer"),1);
	$formSelectCommande->ajouterComposantTab();
	$formSelectCommande->creerFormulaire();


	if(isset($_POST['validerFiltreCommande'])){
			if($_POST['selectStatutCommande'] === "Toute"){
				$commandes = CommandeDAO::getAll();
			}
			else{
				$statut = $_POST['selectStatutCommande'];
				$commandes = CommandeDAO::getByStatut($statut);
			}
		}
		else{
			$commandes = CommandeDAO::getAll();
		}


	$menuCommandes = new Menu("menuCommandes");

	foreach ($commandes as $commande) {

		$menuCommandes->ajouterComposant($menuCommandes->creerItemLien("Commande n° " .$commande['Num'] /*. "  Date :".$commande['DateReception']*/,$commande['Num']));

	}

	$menuCommandes = $menuCommandes->creerMenu("commande",$commandes,"index.php?menuPanel=panelCommande");

	if(isset($_GET['commande'])){
		$numCommande = $_GET['commande'];
		$commande = CommandeDAO::getByNum($numCommande);
		$lignesCommande = LigneCommandeDAO::getByNumCommande($numCommande);
		$formInfoCommande = new Formulaire("post" , "#" ,"formInfoCommande","formInfoCommande");
		$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel("Nom Prénom :","lblNPClient"),1);
		$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel($commande[0]['NomClient']."  " .$commande[0]['PrenomClient'],"lblNPCleint"),1);
		$formInfoCommande->ajouterComposantTab();
		$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel("Mail :","lblNPClient"),1);
		$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel($commande[0]['MailClient'],"lblNPCleint"),1);
		$formInfoCommande->ajouterComposantTab();
		$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel("Téléphone :","lblNPClient"),1);
		$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel($commande[0]['TelephoneClient'],"lblNPCleint"),1);
		$formInfoCommande->ajouterComposantTab();
		$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel("Lieu Réception :","lblNPClient"),1);
		$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel($commande[0]['LieuReception'],"lblNPCleint"),1);
		$formInfoCommande->ajouterComposantTab();
		$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel("Date Réception :","lblNPClient"),1);
		$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel($commande[0]['DateReception'],"lblNPCleint"),1);
		$formInfoCommande->ajouterComposantTab();
		$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel("Prix Total :","lblNPClient"),1);
		$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel($commande[0]['prix']. "  €","lblNPCleint"),1);
		$formInfoCommande->ajouterComposantTab();
		$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel("Produits :","lblNPClient"),1);
		$formInfoCommande->ajouterComposantTab();
		$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel("Nom" , "r"),1);
		$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel("Quantité" , "r"),1);
		$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel("Prix" , "r"),1);
		$formInfoCommande->ajouterComposantTab();
		foreach($lignesCommande as $uneligne){
			$infoProduit = LigneCommandeDAO::getInfoByIdProduit($uneligne['ID'],$uneligne['Num']);
			$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel($infoProduit[0]['Nom'] , "r"),1);
			$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel($infoProduit[0]['Quantite'] , "r"),1);
			$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel($infoProduit[0]['Prix'] * $infoProduit[0]['Quantite']  . " €" , "r"),1);
			$formInfoCommande->ajouterComposantTab();
		}
		$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerInputSubmit("pdf","pdf","Télécharger en PDF"),1);
		if($commande[0]['Statut'] == "En attente"){
			$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerInputSubmit("prete","prete","Commande prête"),1);
		}
		else if($commande[0]['Statut'] == "Prête"){
			$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerLabel("Commande Prête","cmdP"),1);
			$formInfoCommande->ajouterComposantLigne($formInfoCommande->creerInputSubmit("receptionne","receptionne","Commande receptionné"),1);
		}
		$formInfoCommande->ajouterComposantTab();
		$formInfoCommande->creerFormulaire();
	}

	if(isset($_POST['pdf'])){
		$data = $_GET['commande'];
		header('Location: pdf/commandePDF?nCom='.urlencode($data));
		exit();
	}
	if(isset($_POST['prete'])){
		$num = $_GET['commande'];
		CommandeDAO::updateStatut($num,"Prête");
		$url = $_SERVER['REQUEST_URI'];
		header('Location: ' . $url);
		exit();
	}
	if(isset($_POST['receptionne'])){
		$num = $_GET['commande'];
		CommandeDAO::updateStatut($num,"Réceptionné");
		$url = $_SERVER['REQUEST_URI'];
		header('Location: ' . $url);
		exit();
	}
}











include_once 'vues/vuePanel.php' ;

?>