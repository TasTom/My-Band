<!DOCTYPE html>
<html lang="fr">
<head>
    <title>TP2 PHP Par TAS Tom</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="component/header.css">
    <link rel="stylesheet" href="bandSetList.css">
    <link rel="stylesheet" href="bandSetList.css">
    <script src="rechercher.js"></script>
    <!-- Bootstrap pour les modals -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php require_once 'component/header.php'; ?>
    
    <?php
        require_once 'connection.php';
        
        // Traitement des actions CRUD
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'add':
                    if (!empty($_POST['title']) && !empty($_POST['artist']) && !empty($_POST['style'])) {
                        $stmt = $connect->prepare("INSERT INTO setlist (title, artist, style) VALUES (?, ?, ?)");
                        $stmt->execute([$_POST['title'], $_POST['artist'], $_POST['style']]);
                    }
                    break;
                    
                case 'edit':
                    if (!empty($_POST['old_title']) && !empty($_POST['old_artist']) && 
                        !empty($_POST['title']) && !empty($_POST['artist']) && !empty($_POST['style'])) {
                        $stmt = $connect->prepare("UPDATE setlist SET title = ?, artist = ?, style = ? WHERE title = ? AND artist = ?");
                        $stmt->execute([$_POST['title'], $_POST['artist'], $_POST['style'], $_POST['old_title'], $_POST['old_artist']]);
                    }
                    break;
                    
                case 'delete':
                    if (!empty($_POST['title']) && !empty($_POST['artist'])) {
                        $stmt = $connect->prepare("DELETE FROM setlist WHERE title = ? AND artist = ?");
                        $stmt->execute([$_POST['title'], $_POST['artist']]);
                    }
                    break;
            }
        }
        
        // Gestion du tri
        if (isset($_GET['order']) && $_GET['order'] == 'ASC') {
            $order = 'DESC';
        } else {
            $order = 'ASC';
        }
        
        if (isset($_GET['column']) && $_GET['column'] == 'title') {
            $sql = 'SELECT * FROM setlist ORDER BY title '.$order;
        } elseif (isset($_GET['column']) && $_GET['column'] == 'artist') {
            $sql = 'SELECT * FROM setlist ORDER BY artist '.$order;
        } elseif (isset($_GET['column']) && $_GET['column'] == 'style') {
            $sql = 'SELECT * FROM setlist ORDER BY style '.$order;
        } else {
            $sql = 'SELECT * FROM setlist';
        }

        $result = $connect->query($sql);
        if ($result === false) {
            echo "La table setlist n'existe pas !";
        } else {
    ?>
    
    <h2 class="centre">Set List</h2>
    
    <table class="centre" id="jolie">
        <tr>
            <th colspan="<?php echo (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) ? '5' : '3'; ?>"> 
                <input type="text" placeholder="Rechercher..." id="recherche" onkeyup="rechercher()">
            </th>
        </tr>
        <tr>
            <th><a href="bandSetList.php?order=<?php echo $order;?>&column=title">Titre</a></th>
            <th><a href="bandSetList.php?order=<?php echo $order;?>&column=artist">Artiste</a></th>
            <th><a href="bandSetList.php?order=<?php echo $order;?>&column=style">Style</a></th>
            
            <!-- Colonnes d'actions (seulement si connecté) -->
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                <th colspan="2"> 
                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                        ➕ Ajouter
                    </button>
                </th>
            <?php endif; ?>
        </tr>
        
        <?php foreach ($result as $row): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['artist']); ?></td>
            <td><?php echo htmlspecialchars($row['style']); ?></td>
            
            <!-- Boutons d'action (seulement si connecté) -->
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                <td>
                    <button class="btn btn-primary btn-sm edit-btn" 
                            data-bs-toggle="modal" 
                            data-bs-target="#editModal"
                            data-title="<?php echo htmlspecialchars($row['title']); ?>"
                            data-artist="<?php echo htmlspecialchars($row['artist']); ?>"
                            data-style="<?php echo htmlspecialchars($row['style']); ?>">
                        ✏️
                    </button>
                </td>
                <td>
                    <button class="btn btn-danger btn-sm delete-btn" 
                            data-bs-toggle="modal" 
                            data-bs-target="#deleteModal"
                            data-title="<?php echo htmlspecialchars($row['title']); ?>"
                            data-artist="<?php echo htmlspecialchars($row['artist']); ?>">
                        🗑️
                    </button>
                </td>
            <?php endif; ?>
        </tr>
        <?php endforeach; ?>
        
        <?php } ?>
    </table>

    <!-- Modal Ajouter -->
    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
    <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">➕ Ajouter une chanson</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add">
                        <div class="mb-3">
                            <label for="addTitle" class="form-label">Titre</label>
                            <input type="text" class="form-control" id="addTitle" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="addArtist" class="form-label">Artiste</label>
                            <input type="text" class="form-control" id="addArtist" name="artist" required>
                        </div>
                        <div class="mb-3">
                            <label for="addStyle" class="form-label">Style</label>
                            <input type="text" class="form-control" id="addStyle" name="style" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-success">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Éditer -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">✏️ Éditer la chanson</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="edit">
                        <!-- Champs cachés pour identifier l'enregistrement original -->
                        <input type="hidden" id="editOldTitle" name="old_title">
                        <input type="hidden" id="editOldArtist" name="old_artist">
                        
                        <div class="mb-3">
                            <label for="editTitle" class="form-label">Titre</label>
                            <input type="text" class="form-control" id="editTitle" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="editArtist" class="form-label">Artiste</label>
                            <input type="text" class="form-control" id="editArtist" name="artist" required>
                        </div>
                        <div class="mb-3">
                            <label for="editStyle" class="form-label">Style</label>
                            <input type="text" class="form-control" id="editStyle" name="style" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Sauvegarder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Supprimer -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">🗑️ Confirmer la suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" id="deleteTitle" name="title">
                        <input type="hidden" id="deleteArtist" name="artist">
                        
                        <p>Êtes-vous sûr de vouloir supprimer la chanson :</p>
                        <p><strong id="deleteTitleDisplay"></strong> de <strong id="deleteArtistDisplay"></strong> ?</p>
                        <p class="text-danger">⚠️ Cette action est irréversible !</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Script pour remplir le modal d'édition
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Sauvegarder les valeurs originales pour la requête UPDATE
                document.getElementById('editOldTitle').value = this.dataset.title;
                document.getElementById('editOldArtist').value = this.dataset.artist;
                
                // Pré-remplir le formulaire avec les valeurs actuelles
                document.getElementById('editTitle').value = this.dataset.title;
                document.getElementById('editArtist').value = this.dataset.artist;
                document.getElementById('editStyle').value = this.dataset.style;
            });
        });

        // Script pour remplir le modal de suppression
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('deleteTitle').value = this.dataset.title;
                document.getElementById('deleteArtist').value = this.dataset.artist;
                document.getElementById('deleteTitleDisplay').textContent = this.dataset.title;
                document.getElementById('deleteArtistDisplay').textContent = this.dataset.artist;
            });
        });
    </script>
    
    <?php require_once 'component/footer.php'; ?>
</body>
</html>
