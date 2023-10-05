import React, { useState, useEffect } from 'react';
import { useSearchParams } from "react-router-dom";
import {useCookies} from 'react-cookie';

import axios from "axios";

function Login() {
  const [searchParams, setSearchParams] = useSearchParams();
  const [email, setEmail] = useState('');
  const [name, setName] = useState('');
  const [password, setPassword] = useState('');
  const [confirm, setConfirm] = useState('');
  const [error, setError] = useState(false);
  const [message, setMessage] = useState('');

  const handleEmailChange = (e) => {
    setEmail(e.target.value);
  }
  const handleNameChange = (e) => {
    setName(e.target.value);
  }
  const handlePasswordChange = (e) => {
    setPassword(e.target.value);
  }
  const handleConfirmChange = (e) => {
    setConfirm(e.target.value);
  }

  const handleRegister = (e) => {
    e.preventDefault();
    let user = {
      name,
      email,
      password,
      password_confirmation: confirm,
      code: searchParams.get("code")
    };
    axios.post('/api/auth/register', user)
      .then(result => {
        setMessage('You are now registered to ContactOut.');
        setError(false);
        setEmail("");
        setName("");
        setPassword("");
        setConfirm("");
      })
      .catch(error =>  {
        setMessage('Failed to signup. Please try again.');
        setError(true);
      })
  }

  return (
    <div className="py-5">
      <main className="form-signin">
        <form>
            <img className=" mb-4 w-100" src="https://contactout.com/images/logo-v2@2x.png" />
            <h1 className="h3 mb-3 fw-normal">Sign Up</h1>
            <div className="form-floating">
                <input
                    type="text"
                    className="form-control"
                    value={name}
                    placeholder="Name"
                    onChange={handleNameChange}
                    required
                />
                <label>Name</label>
            </div>
            <div className="form-floating">
                <input
                    type="email"
                    className="form-control"
                    value={email}
                    placeholder="Email Address"
                    onChange={handleEmailChange}
                    required
                />
                <label>Email Address</label>
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
            <div className="form-floating">
                <input
                    type="password"
                    className="form-control"
                    placeholder="Confirm Password"
                    value={confirm}
                    onChange={handleConfirmChange}
                    required
                />
                <label >Confirm Password</label>
            </div>
            {message != "" && 
              <p className={ error ? "text-danger py-2" : "text-success py-2" }>{message}</p>
            }
            <p className="py-1">Already have an account? Login <a href="/login">here</a></p>
            <button
                type="submit"
                className="w-100 btn btn-lg btn-primary"
                onClick={handleRegister}
            >
            Sign Up
            </button>
        </form>
      </main>
    </div>
    );
}
export default Login;