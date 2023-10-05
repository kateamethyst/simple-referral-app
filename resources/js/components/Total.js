import React, { useState, useEffect } from 'react';
import {useCookies} from 'react-cookie';
import axios from "axios";

const Total = ({total}) => {
  return (
    <div className="col-2">
      <div className="card">
        <div className="card-body text-center">
          <h1 className="card-title">{ total }</h1>
          <h3 className="card-text">Overall Referrals</h3>
        </div>
      </div>
    </div>
    );
}
export default Total;