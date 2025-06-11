<style>
        body {
            background-color: #f8f9fa;
        }

        .form-container {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .progress {
            height: 8px;
        }

        .form-step {
            display: none;
        }

        .form-step.active {
            display: block;
        }

        .upload-area {
            width: 128px;
            height: 128px;
            border: 2px dashed #dee2e6;
            border-radius: 0.5rem;
            background-color: #f8f9fa;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .upload-area:hover {
            border-color: #0dcaf0;
            background-color: #e3f2fd;
        }

        .upload-area img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 0.5rem;
        }

        .upload-placeholder {
            color: #6c757d;
            text-align: center;
        }

        .remove-btn {
            position: absolute;
            top: 4px;
            right: 4px;
            background: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .file-name {
            position: absolute;
            bottom: 4px;
            left: 4px;
            right: 4px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 0.25rem;
            padding: 2px 4px;
            font-size: 0.75rem;
            color: #6c757d;
        }

        .file-error {
            position: absolute;
            bottom: 4px;
            left: 4px;
            right: 4px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 0.25rem;
            padding: 2px 4px;
            font-size: 0.75rem;
            color: #dc3545;
        }

       
        .btn-darkblue {
            background-color:rgb(77, 115, 152) !important;
            border-color:rgb(46, 103, 159) !important;
            color: #fff !important;
        }

        .btn-darkblue:hover, .btn-darkblue:focus {
            background-color: #163e6c !important;
            border-color: #163e6c !important;
            color: #fff !important;
        }

        .progress-bar {
            background-color: #0a2540 !important;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #0dcaf0;
            box-shadow: 0 0 0 0.2rem rgba(13, 202, 240, 0.25);
        }

        .select2-container--default .select2-selection--single:focus {
            border-color: #0dcaf0;
            box-shadow: 0 0 0 0.2rem rgba(13, 202, 240, 0.25);
        }
    </style>


   <?php
    
    include_once("libs/dbfunctions.php");
    $dbobject = new dbobject();

    $email = '';
    $is_valid = false;
    $error_message = '';

    if (!isset($_SESSION['username_sess'])) {
        $error_message = "Invalid request. Session expired.";
        header("Location: sign_in.php?error=" . urlencode("Please login first to complete your registration."));
        exit;
    } else {
        
        $username = $_SESSION['username_sess'];
        $is_valid = true;

        //Get merchant_id for the logged in user
        $sql = "SELECT merchant_id FROM userdata WHERE username = '$username' LIMIT 1";
        $result = $dbobject->db_query($sql);
        $merchant_id = isset($result[0]['merchant_id']) ? $result[0]['merchant_id'] : null;
        

        $sql = "SELECT DISTINCT(State) as state,stateid FROM lga order by State";
        $states = $dbobject->db_query($sql);
        $state_id = isset($_POST['state_id']) ? $_POST['state_id'] : '';
    }
    ?>

    <div class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-12 col-xl-12">
                <div class="form-container p-4 p-md-5">
                    <h2 class="text-center text-secondary mb-3 fw-bold">Setup Your Company To Use The Application</h2>
                    <p class="text-center text-muted small mb-4">Fill in your remaining information to complete
                        registration.</p>

                    <!-- Progress Bar -->
                    <div class="progress mb-4">
                        <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated"
                            role="progressbar" style="width: 33%" aria-valuenow="33" aria-valuemin="0"
                            aria-valuemax="100"></div>
                    </div>

                    <form id="multiStepForm" autocomplete="off" enctype="multipart/form-data">
                        <!-- Step 1 - Personal Information -->
                        <div class="form-step active">
                            <div class="row g-3">
                                <input type="hidden" name="merchant_id" value="<?php echo $merchant_id; ?>" />
                                <input type="hidden" name="username"
                                    value="<?php echo $_SESSION['username_sess']; ?>" />
                                <input type="hidden" name="op" value="Users.complete_registration" />

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">First Name</label>
                                    <input type="text" class="form-control" placeholder="First Name" required
                                        id="merchant_first_name" name="merchant_first_name" />
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Last Name</label>
                                    <input type="text" class="form-control" placeholder="Last Name" required
                                        id="merchant_last_name" name="merchant_last_name" />
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Email</label>
                                    <input type="email" class="form-control" placeholder="Email" required
                                        id="merchant_email" name="merchant_email" />
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Phone Number</label>
                                    <input type="tel" class="form-control" placeholder="Phone Number" required
                                        id="merchant_phone" name="merchant_phone" />
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Date of Birth</label>
                                    <input type="date" class="form-control" required id="merchant_dob"
                                        name="merchant_dob" max="" />
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Address</label>
                                    <input type="text" class="form-control" placeholder="Address" required
                                        id="merchant_address" name="merchant_address" />
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">State of Origin</label>
                                    <select class="form-select select2" name="merchant_state" id="merchant_state"
                                        onchange="fetchLgas(this.value)" required>
                                        <option value="">::SELECT STATE::</option>
                                        <?php
                                        foreach ($states as $row) {
                                            echo "<option value='".$row['stateid']."'>".$row['state']."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">LGA</label>
                                    <select class="form-select select2" name="merchant_lga" id="merchant_lga" required>
                                        <option value="">::SELECT LGA::</option>
                                    </select>
                                </div>

                                <div class="col-12 mt-4">
                                    <button type="button" class="btn btn-darkblue w-100 py-2"
                                        onclick="nextStep()">Next</button>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2 - Business Information -->
                        <div class="form-step">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Business Name</label>
                                    <input type="text" class="form-control" placeholder="Business Name" required
                                        id="merchant_business_name" name="merchant_business_name" />
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Business Description</label>
                                    <input type="text" class="form-control" placeholder="Business Description" required
                                        id="merchant_business_description" name="merchant_business_description" />
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Business Email</label>
                                    <input type="email" class="form-control" placeholder="Business Email" required
                                        id="merchant_support_email" name="merchant_support_email" />
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Business Phone</label>
                                    <input type="tel" class="form-control" placeholder="Business Phone" required
                                        id="merchant_business_phone" name="merchant_business_phone" />
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-medium">Upload Business Logo</label>
                                    <div class="upload-area" onclick="document.getElementById('merchant_logo').click()">
                                        <img id="logoPreview" class="d-none" alt="Logo Preview" />
                                        <div id="logoPlaceholder" class="upload-placeholder">
                                            <i class="fas fa-upload fa-2x mb-2"></i>
                                            <div class="small">Click to upload</div>
                                        </div>
                                        <button type="button" id="removeLogoBtn" class="remove-btn d-none"
                                            onclick="removeImage(event, 'merchant_logo', 'logoPreview', 'logoPlaceholder', 'removeLogoBtn')">
                                            <i class="fas fa-times text-danger"></i>
                                        </button>
                                    </div>
                                    <input type="file" class="d-none" id="merchant_logo" name="merchant_logo"
                                        accept="image/*" required
                                        onchange="previewImage(this, 'logoPreview', 'logoPlaceholder', 'removeLogoBtn')" />
                                </div>

                                <div class="col-12 mt-4">
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-outline-secondary px-4"
                                            onclick="prevStep()">Previous</button>
                                        <button type="button" class="btn btn-darkblue px-4"
                                            onclick="nextStep()">Next</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3 - Business Documentation -->
                        <div class="form-step">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">CAC Number</label>
                                    <input type="text" class="form-control" placeholder="CAC Number" required
                                        id="cac_number" name="cac_number" />
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-medium">Upload CAC Document</label>
                                    <div class="upload-area" onclick="document.getElementById('cac_document').click()">
                                        <img id="cacPreview" class="d-none" alt="CAC Preview" />
                                        <div id="cacPlaceholder" class="upload-placeholder">
                                            <i class="fas fa-file-upload fa-2x mb-2"></i>
                                            <div class="small">Click to upload</div>
                                        </div>
                                        <div id="cacFileName" class="file-name d-none"></div>
                                        <button type="button" id="removeCacBtn" class="remove-btn d-none"
                                            onclick="removeImage(event, 'cac_document', 'cacPreview', 'cacPlaceholder', 'removeCacBtn')">
                                            <i class="fas fa-times text-danger"></i>
                                        </button>
                                    </div>
                                    <input type="file" class="d-none" id="cac_document" name="cac_document"
                                        accept=".pdf,.jpg,.jpeg,.png" required
                                        onchange="previewImage(this, 'cacPreview', 'cacPlaceholder', 'removeCacBtn', 'cac')" />
                                </div>

                                <div class="col-12 mt-4">
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-outline-secondary px-4"
                                            onclick="prevStep()">Previous</button>
                                        <button type="submit" id="submitBtn" class="btn btn-darkblue px-4">
                                            Complete Registration
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- BlockUI -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        const steps = document.querySelectorAll(".form-step");
        const progressBar = document.getElementById("progressBar");
        let currentStep = 0;

        function showStep(index) {
            steps.forEach((step, i) => {
                step.classList.toggle("d-none", i !== index);
                step.classList.toggle("active", i === index);
            });
            const percent = ((index + 1) / steps.length) * 100;
            progressBar.style.width = percent + "%";
            progressBar.setAttribute('aria-valuenow', percent);

            updateRequiredFields(); // <-- Add this line
        }

        function validateCurrentStep() {
            const currentForm = steps[currentStep];
            const requiredFields = currentForm.querySelectorAll("input[required], select[required]");
            let valid = true;

            requiredFields.forEach(field => {
                if (!field.value || (field.type === "file" && field.files.length === 0)) {
                    field.classList.add("is-invalid");
                    valid = false;
                } else {
                    field.classList.remove("is-invalid");
                }
            });
            return valid;
        }

        function nextStep() {
            if (!validateCurrentStep()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Required Fields',
                    text: 'Please fill all required fields before proceeding.'
                });
                return;
            }
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        }

        function prevStep() {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        }

        function fetchLgas(stateId) {
            const lgaSelect = $("#merchant_lga");

            if (lgaSelect.data('select2')) {
                lgaSelect.select2('destroy');
            }

            lgaSelect.html('<option value="">Loading LGAs...</option>');

            var payload = {
                op: "Users.getLga",
                state_id: stateId
            };

            $.ajax({
                type: "POST",
                url: "utilities.php",
                data: payload,
                dataType: "json",
                success: function (data) {
                    console.log("LGAs fetched successfully:", data);

                    let options = '<option value="">::SELECT LGA::</option>';
                    data.forEach(lga => {
                        options += `<option value="${lga.id}">${lga.Lga}</option>`;
                    });
                    lgaSelect.html(options);

                    lgaSelect.select2({
                        width: '100%',
                        placeholder: 'Select an option',
                        allowClear: true
                    });
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching LGAs:", error);
                    lgaSelect.html('<option value="">Error loading LGAs</option>');
                    lgaSelect.select2({
                        width: '100%',
                        placeholder: 'Select an option',
                        allowClear: true
                    });
                }
            });
        }

        function previewImage(input, previewId, placeholderId, removeBtnId, type = 'logo') {
            const file = input.files[0];
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById(placeholderId);
            const removeBtn = document.getElementById(removeBtnId);
            let errorSpan = preview.parentElement.querySelector('.file-error');
            if (!errorSpan) {
                errorSpan = document.createElement('div');
                errorSpan.className = 'file-error d-none';
                preview.parentElement.appendChild(errorSpan);
            }
            errorSpan.textContent = '';
            errorSpan.classList.add('d-none');

            let allowedTypes, maxSizeMB;
            if (type === 'logo') {
                allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                maxSizeMB = 5;
            } else if (type === 'cac') {
                allowedTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'];
                maxSizeMB = 10;
            }

            if (!file) {
                preview.classList.add('d-none');
                placeholder.classList.remove('d-none');
                if (removeBtn) removeBtn.classList.add('d-none');
                if (type === 'cac') {
                    document.getElementById('cacFileName').classList.add('d-none');
                    document.getElementById('cacFileName').textContent = '';
                }
                return;
            }

            if (!allowedTypes.includes(file.type)) {
                preview.classList.add('d-none');
                placeholder.classList.remove('d-none');
                if (removeBtn) removeBtn.classList.add('d-none');
                errorSpan.textContent = type === 'logo' ?
                    'Invalid file type. Only JPG, JPEG, PNG, and GIF allowed.' :
                    'Invalid file type. Only PDF, JPG, JPEG, and PNG allowed.';
                errorSpan.classList.remove('d-none');
                input.value = '';
                if (type === 'cac') {
                    document.getElementById('cacFileName').classList.add('d-none');
                    document.getElementById('cacFileName').textContent = '';
                }
                return;
            }

            if (file.size > maxSizeMB * 1024 * 1024) {
                preview.classList.add('d-none');
                placeholder.classList.remove('d-none');
                if (removeBtn) removeBtn.classList.add('d-none');
                errorSpan.textContent = type === 'logo' ?
                    'File too large. Max 5MB allowed.' :
                    'File too large. Max 10MB allowed.';
                errorSpan.classList.remove('d-none');
                input.value = '';
                if (type === 'cac') {
                    document.getElementById('cacFileName').classList.add('d-none');
                    document.getElementById('cacFileName').textContent = '';
                }
                return;
            }

            if (type === 'cac' && file.type === 'application/pdf') {
                preview.classList.add('d-none');
                placeholder.classList.add('d-none');
                if (removeBtn) removeBtn.classList.remove('d-none');
                const fileNameSpan = document.getElementById('cacFileName');
                fileNameSpan.textContent = file.name;
                fileNameSpan.classList.remove('d-none');
                errorSpan.classList.add('d-none');
                return;
            }

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                    placeholder.classList.add('d-none');
                    if (removeBtn) removeBtn.classList.remove('d-none');
                    errorSpan.classList.add('d-none');
                    if (type === 'cac') {
                        document.getElementById('cacFileName').classList.add('d-none');
                        document.getElementById('cacFileName').textContent = '';
                    }
                }
                reader.readAsDataURL(file);
            }
        }

        function removeImage(event, inputId, previewId, placeholderId, removeBtnId) {
            event.stopPropagation();
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById(placeholderId);
            const removeBtn = document.getElementById(removeBtnId);
            let errorSpan = preview.parentElement.querySelector('.file-error');
            if (errorSpan) {
                errorSpan.textContent = '';
                errorSpan.classList.add('d-none');
            }

            input.value = '';
            preview.src = "#";
            preview.classList.add('d-none');
            placeholder.classList.remove('d-none');
            if (removeBtn) removeBtn.classList.add('d-none');
            if (inputId === 'cac_document') {
                document.getElementById('cacFileName').classList.add('d-none');
                document.getElementById('cacFileName').textContent = '';
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            const dobInput = document.getElementById('merchant_dob');
            if (dobInput) {
                const today = new Date();
                today.setFullYear(today.getFullYear() - 18);
                const yyyy = today.getFullYear();
                const mm = String(today.getMonth() + 1).padStart(2, '0');
                const dd = String(today.getDate()).padStart(2, '0');
                dobInput.max = `${yyyy}-${mm}-${dd}`;
            }

            $('.select2').select2({
                width: '100%',
                placeholder: 'Select an option',
                allowClear: true
            });
        });

        function updateRequiredFields() {
    // Remove required from all fields
    document.querySelectorAll('#multiStepForm [required]').forEach(function(field) {
        field.dataset.required = "true";
        field.removeAttribute('required');
    });
    // Add required only to visible fields in the current step
    const currentForm = document.querySelector('.form-step.active');
    if (currentForm) {
        currentForm.querySelectorAll('[data-required="true"]').forEach(function(field) {
            field.setAttribute('required', 'required');
        });
    }
}

        document.getElementById("multiStepForm").addEventListener("submit", function (e) {
            e.preventDefault();

            if (!validateCurrentStep()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Required Fields',
                    text: 'Please fill all required fields before submitting.'
                });
                return;
            }

            const formData = new FormData(this);
            const submitBtn = document.getElementById('submitBtn');

            $.blockUI({
                message: "Processing registration... Please wait...",
            });

            $.ajax({
                type: "post",
                url: "utilities_default.php",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (response) {
                    $.unblockUI();

                    if (response.response_code == 0) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Registration Completed!',
                            text: response.response_message,
                            timer: 3000,
                            showConfirmButton: false
                        });

                        setTimeout(() => {
                            window.location = response.data.redirect || 'home.php';
                        }, 3000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Registration Failed',
                            text: response.response_message
                        });
                    }
                },
                error: function (xhr, status, error) {
                    $.unblockUI();
                    console.error("Error:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: "Unable to process request at the moment! Please try again"
                    });
                }
            });
        });
    </script>


</html>