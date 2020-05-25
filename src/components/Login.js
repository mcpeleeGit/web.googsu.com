import React, { Component } from 'react';
import Alert from 'react-bootstrap/Alert';
import '../Login.css';
import { default as User } from '../features/login/User';
export class Login extends Component {

  constructor(props) {
    super(props);
    this.state = { email:'', password:'', data:[], isLoading: true };
    this.handleChange = this.handleChange.bind(this);
  }

  handleSubmit = (e) => {
    const data = { email:this.state.email, password:this.state.password };
    fetch('api/customer/login',{method: 'POST', headers: {'Accept': 'application/json', 'Content-Type': 'application/json'}, body: JSON.stringify(data)})
      .then(response => response.json())
      .then(data => {
        this.setState({ data: data, isLoading: false });
        console.log(data);
 
        if(data.result === "success") {
          User.setUserLogin('true');
          console.log(User.isLogin());          
          this.props.history.push('/');
        }
        else {
          alert(data.message);
        }
      }) 
      .catch(error => this.setState({ error, isLoading: false }));
    e.preventDefault();
  }

  handleChange(e){
    this.setState({ [e.target.name]:e.target.value })
  }

  bindClick(target){
    alert(target);
  }

  render() {
    return (
      <div className="text-center">
        <h1>Login</h1>
        <form className="form-signin" onSubmit={this.handleSubmit}>
            <h1 className="h3 mb-3 font-weight-normal">SNS Account sign in</h1>
            <img className="mb-8 sns-icon" src="/img/snsicon/naver.PNG" alt="Log in with NAVER" /> 
            <img className="mb-8 sns-icon" src="/img/snsicon/instagram.png" alt="Log in with Instagram" onClick={this.bindClick.bind(this, 'instagram')}/>
            <img className="mb-8 sns-icon" src="/img/snsicon/facebook.png" alt="Log in with FaceBook"/>
            <img className="mb-8 sns-icon" src="/img/snsicon/youtube.png" alt="Log in with YouTube"/>
            <img className="mb-8 sns-icon" src="/img/snsicon/twitter.png" alt="Log in with Twitter"/>
            <img className="mb-8 sns-icon" src="/img/snsicon/kakao.png" alt="Log in with Kakao"/>
            <img className="mb-8 sns-icon" src="/img/snsicon/google.png" alt="Log in with Google"/>
            <hr/>
            <h1 className="h3 mb-3 font-weight-normal">Googsu Account sign in</h1>
            <label htmlFor="inputEmail" className="sr-only">Email address</label>
            <input type="email" id="inputEmail" className="form-control" placeholder="Email address" required="required" autoFocus="autoFocus" name="email" onChange={this.handleChange}/>
            <label htmlFor="inputPassword" className="sr-only">Password</label>
              <input type="password" id="inputPassword" className="form-control" placeholder="Password" required="required" name="password" onChange={this.handleChange}/>
          <button className="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

          <Alert key="1" variant="light">
            Forgot password? 
            <Alert.Link href="/member/PasswordReset"> Password Reset</Alert.Link>.
            <br/>
            New to Googsu? 
            <Alert.Link href="/signup"> Sign Up</Alert.Link>.            
          </Alert>    
            
        </form>
      </div>
    );
  }
}

