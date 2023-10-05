import React, { useState, useEffect } from 'react';
import {useCookies} from 'react-cookie';

import axios from "axios";

function Login() {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState(false);
  const [cookies, setCookie, removeCookie] = useCookies(['token']);


  useEffect(() => {
  }, []);

  const handleEmailChange = (e) => {
    setEmail(e.target.value);
  }

  const handlePasswordChange = (e) => {
    setPassword(e.target.value);
  }

  const handleLogin = (e) => {
    e.preventDefault();
    let credentials = {
      email,
      password
    };
    axios.post('/api/auth/login', credentials)
      .then(result => {
        console.log(result.data.access_token);
        setError(false);
        setCookie('token', result.data.access_token);
        setCookie('user_id', result.data.user.id);
        let dashboardLink = '/referrals';
        if (result.data.user.role.length > 0) {
          setCookie('role', result.data.user.role[0].slug);
          if (result.data.user.role[0].slug == 'admin') {
            dashboardLink = "/admin/referrals";
          }
        }
        location.href = dashboardLink;

      })
      .catch(error =>  {
        setError(true);
      })
  }

  return (
    <div className="py-5">
      <main className="form-signin">
        <form>
          <img className=" mb-4 w-100" src="https://contactout.com/images/logo-v2@2x.png" />
          <h1 className="h3 mb-3 fw-normal">Please sign in</h1>
          <div className="form-floating">
              <input
                  type="email"
                  className="form-control"
                  value={email}
                  placeholder="Email Address"
                  onChange={handleEmailChange}
                  required
              />
              <label >Email address</label>
          </div>
          <div className="form-floating">
              <input
                  type="password"
                  className="form-control"
                  placeholder="Password"
                  value={password}
                  onChange={handlePasswordChange}
                  required
              />
              <label >Password</label>
          </div>
          {error == true && 
              <p className="text-danger">Failed </p>
            }
          <p className="py-3">Not registered yet? Signup <a href="/register">here</a></p>
          <button
              type="submit"
              className="w-100 btn btn-lg btn-primary"
              onClick={handleLogin}
          >
          Sign in
          </button>
        </form>
      </main>
    </div>
    );
}
export default Login;