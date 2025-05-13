<!-- Hero Section -->
<section class="hero-section position-relative">
    <div class="bg-primary py-5 text-white">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold">Contactez-nous</h1>
                    <p class="lead">Nous sommes à votre écoute pour répondre à vos questions</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Informations de contact et formulaire -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Informations de contact -->
            <div class="col-lg-4 mb-4 mb-lg-0">
                <h2 class="section-title border-bottom pb-2 mb-4">Nos coordonnées</h2>
                
                <div class="d-flex mb-4">
                    <div class="flex-shrink-0">
                        <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                    </div>
                    <div class="ms-3">
                        <h5>Adresse</h5>
                        <p>123 Avenue de l'Université<br>Dakar, Sénégal</p>
                    </div>
                </div>
                
                <div class="d-flex mb-4">
                    <div class="flex-shrink-0">
                        <i class="fas fa-phone fa-2x text-primary"></i>
                    </div>
                    <div class="ms-3">
                        <h5>Téléphone</h5>
                        <p>+221 33 123 45 67<br>+221 77 890 12 34</p>
                    </div>
                </div>
                
                <div class="d-flex mb-4">
                    <div class="flex-shrink-0">
                        <i class="fas fa-envelope fa-2x text-primary"></i>
                    </div>
                    <div class="ms-3">
                        <h5>Email</h5>
                        <p>contact@unchk.edu.sn<br>admissions@unchk.edu.sn</p>
                    </div>
                </div>
                
                <div class="d-flex mb-4">
                    <div class="flex-shrink-0">
                        <i class="fas fa-clock fa-2x text-primary"></i>
                    </div>
                    <div class="ms-3">
                        <h5>Horaires d'ouverture</h5>
                        <p>Lundi - Vendredi: 8h00 - 17h00<br>Samedi: 9h00 - 13h00</p>
                    </div>
                </div>
                
                <h5 class="mt-4 mb-3">Suivez-nous</h5>
                <div class="d-flex gap-3">
                    <a href="#" class="btn btn-outline-primary rounded-circle">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="btn btn-outline-primary rounded-circle">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-outline-primary rounded-circle">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#" class="btn btn-outline-primary rounded-circle">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
            
            <!-- Formulaire de contact -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="section-title border-bottom pb-2 mb-4">Envoyez-nous un message</h2>
                        
                        <form action="?page=contact_process" method="POST">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nom" class="form-label">Nom complet</label>
                                    <input type="text" class="form-control" id="nom" name="nom" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="telephone" class="form-label">Téléphone</label>
                                    <input type="tel" class="form-control" id="telephone" name="telephone">
                                </div>
                                <div class="col-md-6">
                                    <label for="sujet" class="form-label">Sujet</label>
                                    <select class="form-select" id="sujet" name="sujet" required>
                                        <option value="" selected disabled>Choisir un sujet</option>
                                        <option value="admission">Admission</option>
                                        <option value="information">Demande d'information</option>
                                        <option value="partenariat">Partenariat</option>
                                        <option value="reclamation">Réclamation</option>
                                        <option value="autre">Autre</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="politique" name="politique" required>
                                        <label class="form-check-label" for="politique">
                                            J'accepte la politique de confidentialité et le traitement de mes données personnelles
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg">Envoyer le message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Carte -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5">Nous localiser</h2>
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="ratio ratio-21x9">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3859.0970976315394!2d-17.4639884!3d14.6928842!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTTCsDQxJzM0LjQiTiAxN8KwMjcnNTAuNCJX!5e0!3m2!1sfr!2ssn!4v1635789012345!5m2!1sfr!2ssn" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">Questions fréquentes</h2>
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item border mb-3 shadow-sm">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="#collapseOne">
                                Comment puis-je m'inscrire à l'UNCHK ?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Pour vous inscrire à l'UNCHK, vous devez d'abord créer un compte sur notre plateforme d'admission en ligne. Ensuite, complétez le formulaire d'inscription et téléchargez les documents requis. Une fois votre dossier soumis, vous recevrez un email de confirmation et pourrez suivre l'état de votre candidature dans votre espace personnel.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border mb-3 shadow-sm">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="