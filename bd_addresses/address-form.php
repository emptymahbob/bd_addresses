<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>বাংলাদেশের ঠিকানা ফর্ম</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <style>
        @font-face {
            font-family: 'SolaimanLipi';
            src: url('SolaimanLipi.ttf') format('truetype');
        }
        body {
            font-family: 'SolaimanLipi', Arial, sans-serif;
            /* direction: rtl; */ /* Removed RTL direction */
        }
        .form-label {
            font-weight: bold;
        }
        select, input {
            font-family: 'SolaimanLipi', Arial, sans-serif;
        }
        .select2-container--bootstrap-5 .select2-selection {
            min-height: 38px;
            font-family: 'SolaimanLipi', Arial, sans-serif;
        }
        .select2-container--bootstrap-5 .select2-selection--single {
            padding-top: 5px;
        }
        .select2-container--bootstrap-5 .select2-results__option {
            font-family: 'SolaimanLipi', Arial, sans-serif;
        }
        .select2-container--bootstrap-5 .select2-search__field {
            font-family: 'SolaimanLipi', Arial, sans-serif;
        }
        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            padding-right: 10px;
        }
        #village {
            direction: ltr; /* Explicitly set village input to LTR */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0 text-center">ঠিকানা ফর্ম</h3>
                    </div>
                    <div class="card-body">
                        <form id="addressForm">
                            <div class="mb-3">
                                <label for="division" class="form-label">বিভাগ</label>
                                <select class="form-select select2" id="division" required>
                                    <option value="">বিভাগ নির্বাচন করুন</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="district" class="form-label">জেলা</label>
                                <select class="form-select select2" id="district" required disabled>
                                    <option value="">জেলা নির্বাচন করুন</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="upazila" class="form-label">উপজেলা/থানা</label>
                                <select class="form-select select2" id="upazila" required disabled>
                                    <option value="">উপজেলা/থানা নির্বাচন করুন</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="postOffice" class="form-label">পোস্ট অফিস</label>
                                <select class="form-select select2" id="postOffice" required disabled>
                                    <option value="">পোস্ট অফিস নির্বাচন করুন</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="village" class="form-label">গ্রাম/মহল্লা</label>
                                <input type="text" class="form-control" id="village" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">জমা দিন</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 for all select elements
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: function() {
                    return $(this).data('placeholder');
                },
                allowClear: true
            });

            const divisionSelect = $('#division');
            const districtSelect = $('#district');
            const upazilaSelect = $('#upazila');
            const postOfficeSelect = $('#postOffice');
            
            // Load divisions
            fetch('api.php?action=divisions')
                .then(response => response.json())
                .then(data => {
                    data.forEach(division => {
                        const option = new Option(division.bn_name, division.id);
                        divisionSelect.append(option);
                    });
                    divisionSelect.trigger('change');
                });
            
            // Division change event
            divisionSelect.on('change', function() {
                const divisionId = this.value;
                districtSelect.prop('disabled', !divisionId);
                districtSelect.empty().append('<option value="">জেলা নির্বাচন করুন</option>');
                upazilaSelect.empty().append('<option value="">উপজেলা/থানা নির্বাচন করুন</option>');
                postOfficeSelect.empty().append('<option value="">পোস্ট অফিস নির্বাচন করুন</option>');
                upazilaSelect.prop('disabled', true);
                postOfficeSelect.prop('disabled', true);
                
                if (divisionId) {
                    fetch(`api.php?action=districts&division_id=${divisionId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(district => {
                                const option = new Option(district.bn_name, district.id);
                                districtSelect.append(option);
                            });
                            districtSelect.trigger('change');
                        });
                }
            });
            
            // District change event
            districtSelect.on('change', function() {
                const districtId = this.value;
                upazilaSelect.prop('disabled', !districtId);
                upazilaSelect.empty().append('<option value="">উপজেলা/থানা নির্বাচন করুন</option>');
                postOfficeSelect.empty().append('<option value="">পোস্ট অফিস নির্বাচন করুন</option>');
                postOfficeSelect.prop('disabled', true);
                
                if (districtId) {
                    // Load upazilas
                    fetch(`api.php?action=upazilas&district_id=${districtId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(upazila => {
                                const option = new Option(upazila.bn_name, upazila.id);
                                upazilaSelect.append(option);
                            });
                            upazilaSelect.trigger('change');
                        });
                    
                    // Load post offices
                    fetch(`api.php?action=postoffices&district_id=${districtId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(postoffice => {
                                const option = new Option(postoffice.bn_postOffice, postoffice.postOffice);
                                postOfficeSelect.append(option);
                            });
                            postOfficeSelect.prop('disabled', false);
                            postOfficeSelect.trigger('change');
                        });
                }
            });
            
            // Form submit event
            $('#addressForm').on('submit', function(e) {
                e.preventDefault();
                const formData = {
                    division: divisionSelect.find('option:selected').text(),
                    district: districtSelect.find('option:selected').text(),
                    upazila: upazilaSelect.find('option:selected').text(),
                    postOffice: postOfficeSelect.find('option:selected').text(),
                    village: $('#village').val()
                };
                console.log('Form Data:', formData);
                // Here you can add code to submit the form data to your server
            });
        });
    </script>
</body>
</html> 