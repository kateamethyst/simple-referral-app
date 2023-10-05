import React from 'react';
import ReactDOM from 'react-dom';
import {useCookies} from 'react-cookie';

function Navbar() {
  const [cookies, setCookie, removeCookie] = useCookies(['token']);

  const handleClickLogout = () => {
    removeCookie('token');
    removeCookie('user_id');
    removeCookie('role');
    location.href = "/login";
  }

  return (
    <nav className="navbar navbar-expand-lg navbar-light bg-light border-bottom">
      <div className="container">
        <a className="navbar-brand" href="/referrals">
          <img src="https://contactout.com/images/logo-v2@2x.png" className="w-25 object-contain" />
          </a>
        <button className="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span className="navbar-toggler-icon"></span>
        </button>

        <div className="collapse navbar-collapse">
          <ul className="navbar-nav mr-auto">
            <li className="nav-item">
              <button className="btn btn-link" onClick={handleClickLogout}>Logout</button>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  );
}

export default Navbar;

