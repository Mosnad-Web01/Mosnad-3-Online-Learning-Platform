import { useState } from "react";
import axios from "axios";

export default function VerifyEmail() {
  const [verificationCode, setVerificationCode] = useState("");
  const [errorMessage, setErrorMessage] = useState("");
  const [successMessage, setSuccessMessage] = useState("");

  const handleVerifyCode = async () => {
    try {
      const response = await axios.post("http://localhost:8000/api/verify-code", {
        code: verificationCode,
      });

      setSuccessMessage(response.data.message);
      setErrorMessage("");
    } catch (error) {
      setErrorMessage(
        error.response?.data?.message || "Verification failed. Please try again."
      );
      setSuccessMessage("");
    }
  };

  return (
    <div className="verify-container">
      <h3>Enter the verification code sent to your email</h3>
      <input
        type="text"
        value={verificationCode}
        onChange={(e) => setVerificationCode(e.target.value)}
        placeholder="Enter verification code"
      />
      <button onClick={handleVerifyCode}>Verify</button>
      {successMessage && <p className="success-message">{successMessage}</p>}
      {errorMessage && <p className="error-message">{errorMessage}</p>}
    </div>
  );
}
