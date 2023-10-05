import React, { useState, useEffect } from 'react';
import {useCookies} from 'react-cookie';

import axios from "axios";

function Points() {
  const [cookies, setCookie, removeCookie] = useCookies(['token']);
  const [me, setMe] = useState({});

  const fecthMe = () => {
    let axiosHeaders = {
      'Authorization': `Bearer ${cookies.token}`
    };
    axios.get(`/api/me`, {
      headers: axiosHeaders
    }).then(result => {
      setMe(result.data.data);
    })
    .catch(error =>  {
    })
  }

  useEffect(() => {
    fecthMe();
  }, []);

  return (
    <div className="col-2">
      <div className="card">
        <div className="card-body text-center">
          <h1 className="card-title">{ me.points }</h1>
          <h3 className="card-text">Successfull Referrals</h3>
        </div>
      </div>
    </div>
    );
}
export default Points;