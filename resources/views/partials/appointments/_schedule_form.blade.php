<form id="scheduleAppForm">
    <!-- The patient -->
    <div class="form-group">
        <label for="patientId">The patient:</label>
        <select class="form-control" name="patient_id" id="patientId" read-only>
            <option value="{{ $patient->id }}">
                {{ $patient->full_name }}
            </option>
        </select>

        <span class="invalid-feedback patient_id"></span>
    </div>

    <!-- The doctor -->
    <div class="form-group">
        <label for="doctorId">The doctor:</label>
        <select class="form-control" id="doctorId" read-only>
            <option>
                {{ $doctor->full_name }}
            </option>
        </select>
    </div>

    <!-- The appointment date -->
    <div class="form-group">
        <label for="appDate">Appointment date:</label>
        <input type="text" name="app_date" id="appDate" class="form-control"
        placeholder="yyyy-mm-dd" />

        <span class="invalid-feedback app_date"></span>
    </div>

    <!-- The appointment time -->
    <div class="form-group">
        <label for="appTime">Appointment time:</label>
        <input type="text" name="app_time" id="appTime" class="form-control"
        placeholder="hh:mm" />

        <span class="invalid-feedback app_time"></span>
    </div>
</form>
