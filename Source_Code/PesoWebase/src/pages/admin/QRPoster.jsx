export default function QRPoster() {
  return (
    <>
      <section className="panel account-first-notice">
        <div className="qr-heading">
          <img src="/peso-logo.svg" alt="PESO Logo" />
          <div>
            <span>MUNICIPALITY OF AGOO, LA UNION</span>
            <h2>PUBLIC EMPLOYMENT SERVICE OFFICE</h2>
            <b>APPLICANT ACCOUNT ACCESS</b>
          </div>
        </div>
        <p>Applicants must create an account and sign in before they can view jobs or submit an application.</p>
        <div className="qr-instructions">
          <strong>Applicant Instructions:</strong>
          <ol>
            <li>Create an applicant account.</li>
            <li>Sign in through the PESO login page.</li>
            <li>Choose an approved job from the applicant console.</li>
            <li>Complete the application form and submit it for PESO verification.</li>
          </ol>
        </div>
        <footer>
          Public Employment Service Office • Agoo Municipal Hall • Province of La Union
        </footer>
      </section>
    </>
  )
}
