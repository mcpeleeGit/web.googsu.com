import React, { Component } from 'react';
import { Collapse, Container, Navbar, NavbarBrand, NavbarToggler, NavItem, NavLink } from 'reactstrap';
import { Link } from 'react-router-dom';
import NavDropdown from 'react-bootstrap/NavDropdown';
import './NavMenu.css';
import { default as User } from '../features/login/User';

export class NavMenu extends Component {
  static displayName = NavMenu.name;

  constructor (props) {
    super(props);

    this.toggleNavbar = this.toggleNavbar.bind(this);
    this.state = {
      collapsed: true
    };
  }

  toggleNavbar () {
    this.setState({
      collapsed: !this.state.collapsed
    });
  }

  bindClick(target){
    if(target === 'LogOut') {
      User.setUserLogin('false');
      console.log(User.isLogin());     
      window.location = "/";
    }
  }

  render () {
    const Login = () => (
      <NavItem>
        <NavLink tag={Link} className="text-dark" to="/login"><img src="/img/icon/login.png" className="logo-menu" alt="Login"/>Login</NavLink>
      </NavItem>    
      )  
    const LogOut = () => (
      <NavDropdown title="Account" id="my-dropdown">
        <NavDropdown.Item eventKey="5.1" href="/atodo">AToDo</NavDropdown.Item>
        <NavDropdown.Item eventKey="5.3" href="/board-list">Board</NavDropdown.Item>
        <NavDropdown.Divider />
        <NavDropdown.Item eventKey="5.4" onClick={this.bindClick.bind(this, 'LogOut')}>LogOut</NavDropdown.Item>
      </NavDropdown>    
      )        

    return (
      <header>
        <Navbar className="navbar-expand-sm navbar-toggleable-sm ng-white border-bottom box-shadow mb-3" light>
          <Container>
            <NavbarBrand tag={Link} to="/"><img src="/img/icon/googsu.png" className="logo" alt="logo"/>Googsu WebApplication1</NavbarBrand>
            <NavbarToggler onClick={this.toggleNavbar} className="mr-2" />
            <Collapse className="d-sm-inline-flex flex-sm-row-reverse" isOpen={!this.state.collapsed} navbar>
              <ul className="navbar-nav flex-grow">
                <NavItem>
                  <NavLink tag={Link} className="text-dark" to="/"><img src="/img/icon/home.png" className="logo-menu" alt="Home"/>Home</NavLink>
                </NavItem>
                <NavItem>
                  <NavLink tag={Link} className="text-dark" to="/counter"><img src="/img/icon/counter.png" className="logo-menu" alt="Counter"/>Counter</NavLink>
                </NavItem>
                <NavItem>
                  <NavLink tag={Link} className="text-dark" to="/fetch-data"><img src="/img/icon/fetchdata.png" className="logo-menu" alt="Fetch data"/>Fetch data</NavLink>                  
                </NavItem>
                <NavDropdown title="▤ReBoPAW" id="nav-dropdown">
                  <NavDropdown.Item eventKey="4.1" href="/what-is-rebopaw">What is ReBoPAW?</NavDropdown.Item>
                  <NavDropdown.Item eventKey="4.2" href="/achitecture">Achitecture</NavDropdown.Item>
                  <NavDropdown.Item eventKey="4.3" href="/tutorial">Tutorial</NavDropdown.Item>
                  <NavDropdown.Divider />
                  <NavDropdown.Item eventKey="4.4" href="https://github.com/mcpeleeGit/onlyPHP" target="_blank">DownLoad</NavDropdown.Item>
                </NavDropdown>                
                {!User.isLogin() && <Login/> }
                {User.isLogin() && <LogOut/> }
              </ul>
            </Collapse>
          </Container>
        </Navbar>
      </header>
    );
  }
}